<?php
/**
 * Copyright (C) 2017 Lyra Network.
 * This file is part of Lyra payment form API.
 * See COPYING.txt for license details.
 *
 * @author Lyra Network <contact@lyra-network.com>
 * @copyright 2017 Lyra Network
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

/**
 * Associative array containing human-readable translations of response codes.
 *
 * @var array
 */
global $i18n;

$i18n = array();

$i18n['unknown'] = 'Unknown';

$i18n['result'] = array(
    'empty' => '',
    '00' => 'Action successfully completed',
    '02' => 'The merchant must contact the cardholder\'s bank',
    '05' => 'Action rejected',
    '17' => 'Action canceled',
    '30' => 'Request format error',
    '96' => 'Technical issue'
);

$i18n['auth_result'] = array(
    'empty' => '',
    '00' => 'Approved or successfully processed transaction',
    '02' => 'Contact the card issuer',
    '03' => 'Invalid acceptor',
    '04' => 'Keep the card',
    '05' => 'Do not honor',
    '07' => 'Keep the card, special conditions',
    '08' => 'Confirm after identification',
    '12' => 'Invalid transaction',
    '13' => 'Invalid amount',
    '14' => 'Invalid cardholder number',
    '30' => 'Format error',
    '31' => 'Unknown acquirer company ID',
    '33' => 'Expired card',
    '34' => 'Fraud suspected',
    '41' => 'Lost card',
    '43' => 'Stolen card',
    '51' => 'Insufficient balance or exceeded credit limit',
    '54' => 'Expired card',
    '56' => 'Card absent from the file',
    '57' => 'Transaction not allowed to this cardholder',
    '58' => 'Transaction not allowed to this cardholder',
    '59' => 'Suspected fraud',
    '60' => 'Card acceptor must contact the acquirer',
    '61' => 'Withdrawal limit exceeded',
    '63' => 'Security rules unfulfilled',
    '68' => 'Response not received or received too late',
    '90' => 'Temporary shutdown',
    '91' => 'Unable to reach the card issuer',
    '96' => 'System malfunction',
    '94' => 'Duplicate transaction',
    '97' => 'Overall monitoring timeout',
    '98' => 'Server not available, new network route requested',
    '99' => 'Initiator domain incident'
);

$i18n['warranty_result'] = array(
    'empty' => 'Payment guarantee not applicable',
    'YES' => 'The payment is guaranteed',
    'NO' => 'The payment is not guaranteed',
    'UNKNOWN' => 'Due to a technical error, the payment cannot be guaranteed'
);

$i18n['risk_control'] = array(
    'CARD_FRAUD' => 'Card number control',
    'SUSPECT_COUNTRY' => 'Card country control',
    'IP_FRAUD' => 'IP address control',
    'CREDIT_LIMIT' => 'Card outstanding control',
    'BIN_FRAUD' => 'BIN code control',
    'ECB' => 'E-carte bleue control',
    'COMMERCIAL_CARD' => 'Commercial card control',
    'SYSTEMATIC_AUTO' => 'Systematic authorization card control',
    'INCONSISTENT_COUNTRIES' => 'Countries consistency control (IP, card, shipping address)',
    'NON_WARRANTY_PAYMENT' => 'Transfer of responsibility control',
    'SUSPECT_IP_COUNTRY' => 'IP country control'
);

$i18n['risk_assessment'] = array(
    'ENABLE_3DS' => '3-D Secure enabled',
    'DISABLE_3DS' => '3-D Secure disabled',
    'MANUAL_VALIDATION' => 'The transaction has been created via manual validation',
    'REFUSE' => 'The transaction is refused',
    'RUN_RISK_ANALYSIS' => 'Call for an external risk analyser',
    'INFORM' => 'A warning message appears'
);

$i18n['ipn_response'] = array(
    'payment_ok' => 'Valid payment processed',
    'payment_ko' => 'Invalid payment processed',
    'payment_ok_already_done' => 'Valid payment processed, already saved',
    'payment_ko_already_done' => 'Invalid payment processed, already saved',
    'ok' => '',
    'order_not_found' => 'Order not found',
    'payment_ko_on_order_ok' => 'Invalid payment result received for already validated order',
    'auth_fail' => 'Authentication failed',
    'empty_cart' => 'The cart was emptied before redirection',
    'unknown_status' => 'Unknown order status',
    'amount_error' => 'The amount paid is different from initial amount',
    'ko' => ''
);
