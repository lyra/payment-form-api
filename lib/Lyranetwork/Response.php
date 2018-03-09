<?php
/**
 * Copyright (C) 2017-2018 Lyra Network.
 * This file is part of Lyra payment form API.
 * See COPYING.md for license details.
 *
 * @author Lyra Network <contact@lyra-network.com>
 * @copyright 2017-2018 Lyra Network
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */
namespace Lyranetwork;

/**
 * Class representing the result of a transaction (sent by the IPN URL or by the client return).
 */
class Response
{

    const TYPE_RESULT = 'result';

    const TYPE_AUTH_RESULT = 'auth_result';

    const TYPE_WARRANTY_RESULT = 'warranty_result';

    const TYPE_RISK_CONTROL = 'risk_control';

    const TYPE_RISK_ASSESSMENT = 'risk_assessment';

    /**
     * Raw response parameters array.
     *
     * @var array[string][string]
     */
    private $rawResponse = array();

    /**
     * Certificate to use in TEST mode.
     *
     * @var string
     */
    private $keyTest;

    /**
     * Certificate to use in PRODUCTION mode.
     *
     * @var string
     */
    private $keyProd;

    /**
     * Algorithm used to check the signature.
     *
     * @see Util::sign
     * @var string
     */
    private $algo;

    /**
     * Value of vads_result.
     *
     * @var string
     */
    private $result;

    /**
     * Value of vads_extra_result.
     *
     * @var string
     */
    private $extraResult;

    /**
     * Value of vads_auth_result.
     *
     * @var string
     */
    private $authResult;

    /**
     * Value of vads_warranty_result.
     *
     * @var string
     */
    private $warrantyResult;

    /**
     * Transaction status (value of vads_trans_status).
     *
     * @var string
     */
    private $transStatus;

    /**
     * Constructor for Response class.
     * Prepare to analyse IPN URL or return URL call.
     *
     * @param array[string][string] $params
     * @param string $key_test
     * @param string $key_prod
     * @param string $algo
     */
    public function __construct($params, $key_test, $key_prod, $algo = Util::ALGO_SHA1)
    {
        $this->rawResponse = Util::uncharm($params);
        $this->keyTest = trim($key_test);
        $this->keyProd = trim($key_prod);

        if (! in_array($algo, Util::$SUPPORTED_ALGOS)) {
            throw new \InvalidArgumentException("Algorithm passed ($algo) is not supported.");
        }

        $this->algo = $algo;

        // payment results
        $this->result = Util::findInArray('vads_result', $this->rawResponse, null);
        $this->extraResult = Util::findInArray('vads_extra_result', $this->rawResponse, null);
        $this->authResult = Util::findInArray('vads_auth_result', $this->rawResponse, null);
        $this->warrantyResult = Util::findInArray('vads_warranty_result', $this->rawResponse, null);

        $this->transStatus = Util::findInArray('vads_trans_status', $this->rawResponse, null);
    }

    /**
     * Check response signature.
     *
     * @return bool
     */
    public function isAuthentified()
    {
        return $this->getComputedSignature() === $this->getSignature();
    }

    /**
     * Return the signature computed from the received parameters, for log / debug purposes.
     *
     * @param bool $hashed
     * @return string
     */
    public function getComputedSignature($hashed = true)
    {
        $certificate = ($this->get('ctx_mode') === 'PRODUCTION') ? $this->keyProd : $this->keyTest;
        return Util::sign($this->rawResponse, $certificate, $this->algo, $hashed);
    }

    /**
     * Check if the payment was successful (waiting confirmation or captured).
     *
     * @return bool
     */
    public function isAcceptedPayment()
    {
        $confirmed_statuses = array(
            'AUTHORISED',
            'AUTHORISED_TO_VALIDATE',
            'CAPTURED',
            'CAPTURE_FAILED' /* capture will be redone */
        );

        return in_array($this->transStatus, $confirmed_statuses) || $this->isPendingPayment();
    }

    /**
     * Check if the payment is waiting confirmation (successful but the amount has not been
     * transfered and is not yet guaranteed).
     *
     * @return bool
     */
    public function isPendingPayment()
    {
        $pending_statuses = array(
            'INITIAL',
            'WAITING_AUTHORISATION',
            'WAITING_AUTHORISATION_TO_VALIDATE',
            'UNDER_VERIFICATION'
        );

        return in_array($this->transStatus, $pending_statuses);
    }

    /**
     * Check if the payment process was interrupted by the client.
     *
     * @return bool
     */
    public function isCancelledPayment()
    {
        $cancelled_statuses = array(
            'NOT_CREATED',
            'ABANDONED'
        );

        return in_array($this->transStatus, $cancelled_statuses);
    }

    /**
     * Check if the payment is to validate manually in the payment platform Back Office.
     *
     * @return bool
     */
    public function isToValidatePayment()
    {
        $to_validate_statuses = array(
            'WAITING_AUTHORISATION_TO_VALIDATE',
            'AUTHORISED_TO_VALIDATE'
        );

        return in_array($this->transStatus, $to_validate_statuses);
    }

    /**
     * Check if the payment is suspected to be fraudulent.
     *
     * @return bool
     */
    public function isSuspectedFraud()
    {
        // at least one control failed ...
        $risk_control = $this->getRiskControl();
        if (in_array('WARNING', $risk_control) || in_array('ERROR', $risk_control)) {
            return true;
        }

        // or there was an alert from risk assessment module
        $risk_assessment = $this->getRiskAssessment();
        if (in_array('INFORM', $risk_assessment)) {
            return true;
        }

        return false;
    }

    /**
     * Return the risk control result.
     *
     * @return array[string][string]
     */
    public function getRiskControl()
    {
        $risk_control = $this->get('risk_control');
        if (! isset($risk_control) || ! trim($risk_control)) {
            return array();
        }

        // get a URL-like string
        $risk_control = str_replace(';', '&', $risk_control);

        $result = array();
        parse_str($risk_control, $result);

        return $result;
    }

    /**
     * Return the risk assessment result.
     *
     * @return array[string]
     */
    public function getRiskAssessment()
    {
        $risk_assessment = $this->get('risk_assessment_result');
        if (! isset($risk_assessment) || ! trim($risk_assessment)) {
            return array();
        }

        return explode(';', $risk_assessment);
    }

    /**
     * Return the value of a response parameter.
     *
     * @param string $name
     * @return string
     */
    public function get($name)
    {
        // manage shortcut notations by adding 'vads_'
        $name = (substr($name, 0, 5) != 'vads_') ? 'vads_' . $name : $name;

        return isset($this->rawResponse[$name]) ? $this->rawResponse[$name] : '';
    }

    /**
     * Shortcut for getting ext_info_* fields.
     *
     * @param string $key
     * @return string
     */
    public function getExtInfo($key)
    {
        return $this->get("ext_info_$key");
    }

    /**
     * Return the expected signature received from platform.
     *
     * @return string
     */
    public function getSignature()
    {
        return isset($this->rawResponse['signature']) ? $this->rawResponse['signature'] : '';
    }

    /**
     * Return the paid amount converted from cents (or currency equivalent) to a decimal value.
     *
     * @return float
     */
    public function getFloatAmount()
    {
        $currency = Util::findCurrencyByNumCode($this->get('currency'));
        return $currency->convertAmountToFloat($this->get('amount'));
    }

    /**
     * Return the payment response result.
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Return the payment response extra result.
     *
     * @return string
     */
    public function getExtraResult()
    {
        return $this->extraResult;
    }

    /**
     * Return the payment response authentication result.
     *
     * @return string
     */
    public function getAuthResult()
    {
        return $this->authResult;
    }

    /**
     * Return the payment response warranty result.
     *
     * @return string
     */
    public function getWarrantyResult()
    {
        return $this->warrantyResult;
    }

    /**
     * Return all the payment response results as array.
     *
     * @return array[string][string]
     */
    public function getAllResults()
    {
        return array(
            'result' => $this->result,
            'extra_result' => $this->extraResult,
            'auth_result' => $this->authResult,
            'warranty_result' => $this->warrantyResult
        );
    }

    /**
     * Return the payment transaction status.
     *
     * @return string
     */
    public function getTransStatus()
    {
        return $this->transStatus;
    }

    /**
     * Return the response message translated to the payment langauge.
     *
     * @param $result_type string
     * @return string
     */
    public function getMessage($result_type = self::TYPE_RESULT)
    {
        $text = '';

        $text .= self::translate($this->get($result_type), $result_type, $this->get('language'), true);
        if ($result_type === self::TYPE_RESULT && $this->get($result_type) === '30' /* form error */) {
            $text .= ' ' . self::extraMessage($this->extraResult);
        }

        return $text;
    }

    /**
     * Return the complete response message translated to the payment langauge.
     *
     * @param $result_type string
     * @return string
     */
    public function getCompleteMessage($sep = ' ')
    {
        $text = $this->getMessage(self::TYPE_RESULT);
        $text .= $sep . $this->getMessage(self::TYPE_AUTH_RESULT);
        $text .= $sep . $this->getMessage(self::TYPE_WARRANTY_RESULT);

        return trim($text);
    }

    /**
     * Return a short description of the payment result, useful for logging.
     *
     * @return string
     */
    public function getLogMessage()
    {
        $text = '';

        $text .= self::translate($this->result, self::TYPE_RESULT, 'en', true);
        if ($this->result === '30' /* form error */) {
            $text .= ' ' . self::extraMessage($this->extraResult);
        }

        $text .= ' ' . self::translate($this->authResult, self::TYPE_AUTH_RESULT, 'en', true);
        $text .= ' ' . self::translate($this->warrantyResult, self::TYPE_WARRANTY_RESULT, 'en', true);

        return trim($text);
    }

    /**
     * Return a formatted string to output as a response to the notification URL call.
     *
     * @param string $code shortcut code for current situations. Most useful : payment_ok, payment_ko, auth_fail
     * @param string $extra_message some extra information to output to the payment platform
     * @return string
     */
    public function getOutputForPlatform($code, $extra_message = '')
    {
        if (! key_exists($code, self::$IPN_RESPONSES)) {
            $code = 'ko';
        }

        /**
         * @var array[status, message] $case
         */
        $case = self::$IPN_RESPONSES[$code];

        $success = $case['status'];
        $message = $case['message'];

        if (! empty($extra_message)) {
            $message .= ' ' . $extra_message;
        }

        $message = str_replace("\n", ' ', trim($message));

        $content = $success ? 'OK-' : 'KO-';
        $content .= "$message\n";

        $response = '';
        $response .= '<span style="display:none">';
        $response .= htmlspecialchars($content, ENT_COMPAT, 'UTF-8');
        $response .= '</span>';

        return $response;
    }

    /**
     * Return a translated short description of the payment result for a specified language.
     *
     * @param string $result
     * @param string $result_type
     * @param string $lang
     * @param boolean $append_code
     * @return string
     */
    public static function translate($result, $result_type, $lang, $append_code = false)
    {
        global $i18n;

        if (! is_file(dirname(__FILE__) . "/i18n/messages.$lang.php")) {
            // by default, load english translations
            $lang = 'en';
        }

        include_once dirname(__FILE__) . "/i18n/messages.$lang.php";

        $text = Util::findInArray($result ? $result : 'empty', $i18n[$result_type], $i18n['unknown']);

        if ($text && $append_code) {
            $text = self::appendResultCode($text, $result);
        }

        return $text;
    }

    public static function appendResultCode($message, $result_code)
    {
        if ($result_code) {
            $message .= ' (' . $result_code . ')';
        }

        return $message . '.';
    }

    public static function extraMessage($extra_result)
    {
        $error = Util::findInArray($extra_result, self::$FORM_ERRORS, 'OTHER');
        return self::appendResultCode($error, $extra_result);
    }

    public static $IPN_RESPONSES = array(
        'payment_ok' => array('status' => true, 'message' => 'Accepted payment, order has been updated.'),
        'payment_ko' => array('status' => true, 'message' => 'Payment failure, order has been cancelled.'),
        'payment_ko_bis' => array('status' => true, 'message' => 'Payment failure.'),
        'payment_ok_already_done' => array('status' => true, 'message' => 'Accepted payment, already registered.'),
        'payment_ko_already_done' => array('status' => true, 'message' => 'Payment failure, already registered.'),
        'order_not_found' => array('status' => false, 'message' => 'Order not found.'),
        'payment_ko_on_order_ok' => array('status' => false, 'message' => 'Order status does not match the payment result.'),
        'auth_fail' => array('status' => false, 'message' => 'An error occurred while computing the signature.'),
        'empty_cart' => array('status' => false, 'message' => 'Empty cart detected before order processing.'),
        'unknown_status' => array('status' => false, 'message' => 'Unknown order status.'),
        'amount_error' => array('status' => false, 'message' => 'Total paid is different from order amount.'),
        'ok' => array('status' => true, 'message' => ''),
        'ko' => array('status' => false, 'message' => '')
    );

    public static $FORM_ERRORS = array(
        '00' => 'SIGNATURE',
        '01' => 'VERSION',
        '02' => 'SITE_ID',
        '03' => 'TRANS_ID',
        '04' => 'TRANS_DATE',
        '05' => 'VALIDATION_MODE',
        '06' => 'CAPTURE_DELAY',
        '07' => 'PAYMENT_CONFIG',
        '08' => 'PAYMENT_CARDS',
        '09' => 'AMOUNT',
        '10' => 'CURRENCY',
        '11' => 'CTX_MODE',
        '12' => 'LANGUAGE',
        '13' => 'ORDER_ID',
        '14' => 'ORDER_INFO',
        '15' => 'CUST_EMAIL',
        '16' => 'CUST_ID',
        '17' => 'CUST_TITLE',
        '18' => 'CUST_NAME',
        '19' => 'CUST_ADDRESS',
        '20' => 'CUST_ZIP',
        '21' => 'CUST_CITY',
        '22' => 'CUST_COUNTRY',
        '23' => 'CUST_PHONE',
        '24' => 'URL_SUCCESS',
        '25' => 'URL_REFUSED',
        '26' => 'URL_REFERRAL',
        '27' => 'URL_CANCEL',
        '28' => 'URL_RETURN',
        '29' => 'URL_ERROR',
        '30' => 'IDENTIFIER',
        '31' => 'CONTRIB',
        '32' => 'THEME_CONFIG',
        '33' => 'URL_CHECK',
        '34' => 'REDIRECT_SUCCESS_TIMEOUT',
        '35' => 'REDIRECT_SUCCESS_MESSAGE',
        '36' => 'REDIRECT_ERROR_TIMEOUT',
        '37' => 'REDIRECT_ERROR_MESSAGE',
        '38' => 'RETURN_POST_PARAMS',
        '39' => 'RETURN_GET_PARAMS',
        '40' => 'CARD_NUMBER',
        '41' => 'CARD_EXP_MONTH',
        '42' => 'CARD_EXP_YEAR',
        '43' => 'CARD_CVV',
        '44' => 'CARD_CVV_AND_BIRTH',
        '46' => 'PAGE_ACTION',
        '47' => 'ACTION_MODE',
        '48' => 'RETURN_MODE',
        '49' => 'ABSTRACT_INFO',
        '50' => 'SECURE_MPI',
        '51' => 'SECURE_ENROLLED',
        '52' => 'SECURE_CAVV',
        '53' => 'SECURE_ECI',
        '54' => 'SECURE_XID',
        '55' => 'SECURE_CAVV_ALG',
        '56' => 'SECURE_STATUS',
        '60' => 'PAYMENT_SRC',
        '61' => 'USER_INFO',
        '62' => 'CONTRACTS',
        '63' => 'RECURRENCE',
        '64' => 'RECURRENCE_DESC',
        '65' => 'RECURRENCE_AMOUNT',
        '66' => 'RECURRENCE_REDUCED_AMOUNT',
        '67' => 'RECURRENCE_CURRENCY',
        '68' => 'RECURRENCE_REDUCED_AMOUNT_NUMBER',
        '69' => 'RECURRENCE_EFFECT_DATE',
        '70' => 'EMPTY_PARAMS',
        '71' => 'AVAILABLE_LANGUAGES',
        '72' => 'SHOP_NAME',
        '73' => 'SHOP_URL',
        '74' => 'OP_COFINOGA',
        '75' => 'OP_CETELEM',
        '76' => 'BIRTH_DATE',
        '77' => 'CUST_CELL_PHONE',
        '79' => 'TOKEN_ID',
        '80' => 'SHIP_TO_NAME',
        '81' => 'SHIP_TO_STREET',
        '82' => 'SHIP_TO_STREET2',
        '83' => 'SHIP_TO_CITY',
        '84' => 'SHIP_TO_STATE',
        '85' => 'SHIP_TO_ZIP',
        '86' => 'SHIP_TO_COUNTRY',
        '87' => 'SHIP_TO_PHONE_NUM',
        '88' => 'CUST_STATE',
        '89' => 'REQUESTOR',
        '90' => 'PAYMENT_TYPE',
        '91' => 'EXT_INFO',
        '92' => 'CUST_STATUS',
        '93' => 'SHIP_TO_STATUS',
        '94' => 'SHIP_TO_TYPE',
        '95' => 'SHIP_TO_SPEED',
        '96' => 'SHIP_TO_DELIVERY_COMPANY_NAME',
        '97' => 'PRODUCT_LABEL',
        '98' => 'PRODUCT_TYPE',
        '100' => 'PRODUCT_REF',
        '101' => 'PRODUCT_QTY',
        '102' => 'PRODUCT_AMOUNT',
        '103' => 'PAYMENT_OPTION_CODE',
        '104' => 'CUST_FIRST_NAME',
        '105' => 'CUST_LAST_NAME',
        '106' => 'SHIP_TO_FIRST_NAME',
        '107' => 'SHIP_TO_LAST_NAME',
        '108' => 'TAX_AMOUNT',
        '109' => 'SHIPPING_AMOUNT',
        '110' => 'INSURANCE_AMOUNT',
        '111' => 'PAYMENT_ENTRY',
        '112' => 'CUST_ADDRESS_NUMBER',
        '113' => 'CUST_DISTRICT',
        '114' => 'SHIP_TO_STREET_NUMBER',
        '115' => 'SHIP_TO_DISTRICT',
        '116' => 'SHIP_TO_USER_INFO',
        '117' => 'RISK_PRIMARY_WARRANTY',
        '117' => 'DONATION',
        '99' => 'OTHER',
        '118' => 'STEP_UP_DATA',
        '201' => 'PAYMENT_AUTH_CODE',
        '202' => 'PAYMENT_CUST_CONTRACT_NUM',
        '888' => 'ROBOT_REQUEST',
        '999' => 'SENSITIVE_DATA'
    );
}
