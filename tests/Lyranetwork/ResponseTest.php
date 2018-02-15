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

class ResponseTest extends \PHPUnit\Framework\TestCase
{

    private static $acceptedPaymentData;

    private static $failedPaymentData;

    public static function setUpBeforeClass()
    {
        self::$acceptedPaymentData = array(
            'vads_validation_mode' => '0',
            'vads_auth_mode' => 'FULL',
            'vads_page_action' => 'PAYMENT',
            'strong_signature' => '9sopoUOXohjFBpy3nKIxNSp+gQLESOG/P1P+voDIPkA=',
            'vads_warranty_result' => 'YES',
            'vads_currency' => '978',
            'vads_payment_src' => 'EC',
            'vads_cust_email' => 'test@test.com',
            'vads_threeds_cavv' => '',
            'vads_threeds_sign_valid' => '',
            'vads_threeds_cavvAlgorithm' => '',
            'vads_order_id' => 'ja-4013',
            'vads_contract_used' => '5785350',
            'vads_threeds_xid' => '',
            'vads_capture_delay' => '0',
            'vads_auth_number' => '3fe69a',
            'vads_threeds_enrolled' => 'N',
            'vads_expiry_year' => '2018',
            'vads_threeds_eci' => '',
            'vads_effective_currency' => '978',
            'vads_card_brand' => 'CB',
            'vads_payment_config' => 'SINGLE',
            'vads_language' => 'fr',
            'vads_bank_code' => '17807',
            'vads_risk_control' => 'CARD_FRAUD=OK',
            'vads_operation_type' => 'DEBIT',
            'signature' => '814748cc43a3959dc13dbf8eba28387436693085',
            'vads_sequence_number' => '1',
            'vads_threeds_error_code' => '7',
            'vads_card_number' => '497010XXXXXX0001',
            'vads_payment_certificate' => '3cc3ddb343dfc734dd4e760e06abdf733cb83371',
            'vads_result' => '00',
            'vads_trans_uuid' => 'a450413f9ec04fcc9c11b9f3b2103c2c',
            'vads_bank_product' => 'A',
            'vads_trans_date' => '2017-20180705073243',
            'vads_ctx_mode' => 'TEST',
            'vads_action_mode' => 'INTERACTIVE',
            'vads_threeds_status' => '',
            'vads_effective_amount' => '2525',
            'vads_version' => 'V2',
            'vads_presentation_date' => '2017-20180705073311',
            'vads_trans_status' => 'AUTHORISED',
            'vads_pays_ip' => 'FR',
            'vads_trans_id' => '000730',
            'vads_auth_result' => '00',
            'vads_extra_result' => '00',
            'vads_expiry_month' => '6',
            'vads_threeds_exit_status' => '7',
            'vads_card_country' => 'FR',
            'vads_amount' => '2525',
            'vads_effective_creation_date' => '2017-20180705073311',
            'vads_site_id' => '12345678'
        );

        self::$failedPaymentData = array(
            'vads_validation_mode' => '0',
            'vads_auth_mode' => 'FULL',
            'vads_page_action' => 'PAYMENT',
            'strong_signature' => 'lBC3GGHikARqYXEXeClLrVieu1Xfwrn9a41otIRt52w=',
            'vads_warranty_result' => '',
            'vads_currency' => '978',
            'vads_payment_src' => 'EC',
            'vads_cust_email' => 'test@test.com',
            'vads_threeds_cavv' => 'Q2F2dkNhdnZDYXZ2Q2F2dkNhdnY=',
            'vads_threeds_sign_valid' => '1',
            'vads_threeds_cavvAlgorithm' => '2',
            'vads_order_id' => 'GMJ9429',
            'vads_contract_used' => '5785350',
            'vads_threeds_xid' => 'cVpQTXd1SUJBdnduSFFiaGUzOWI=',
            'vads_capture_delay' => '0',
            'vads_auth_number' => '',
            'vads_threeds_enrolled' => 'Y',
            'vads_expiry_year' => '2018',
            'vads_threeds_eci' => '05',
            'vads_effective_currency' => '978',
            'vads_card_brand' => 'CB',
            'vads_payment_config' => 'SINGLE',
            'vads_language' => 'fr',
            'vads_bank_code' => '17807',
            'vads_risk_control' => 'CARD_FRAUD=OK',
            'vads_operation_type' => 'DEBIT',
            'signature' => 'd1042e1d3759a656b13fcbb86c2651a0501a81b6',
            'vads_sequence_number' => '1',
            'vads_threeds_error_code' => '',
            'vads_card_number' => '497010XXXXXX0099',
            'vads_payment_certificate' => '',
            'vads_result' => '05',
            'vads_trans_uuid' => '008cb068c6164eaeb8452ede05e2ad05',
            'vads_bank_product' => 'G1',
            'vads_trans_date' => '2017-20180705081301',
            'vads_ctx_mode' => 'TEST',
            'vads_action_mode' => 'INTERACTIVE',
            'vads_threeds_status' => 'Y',
            'vads_effective_amount' => '8894',
            'vads_version' => 'V2',
            'vads_presentation_date' => '2017-20180705081407',
            'vads_trans_status' => 'REFUSED',
            'vads_pays_ip' => 'FR',
            'vads_trans_id' => '000732',
            'vads_auth_result' => '05',
            'vads_extra_result' => '00',
            'vads_expiry_month' => '6',
            'vads_threeds_exit_status' => '10',
            'vads_card_country' => 'FR',
            'vads_amount' => '8894',
            'vads_effective_creation_date' => '2017-20180705081407',
            'vads_site_id' => '12345678'
        );
    }

    public function testAuthenticatedSha1()
    {
        // check signature for accepted payment data
        $response = new Response(self::$acceptedPaymentData, '1111111111111111', '2222222222222222', Util::ALGO_SHA1);

        $this->assertTrue($response->isAuthentified(), 'Error in computed signature.');

        $expected = 'INTERACTIVE+2525+FULL+3fe69a+00+17807+A+0+CB+FR+497010XXXXXX0001+5785350+TEST+978+test@test.com+2525+2017-20180705073311+978+6+2018+00+fr+DEBIT+ja-4013+PAYMENT+3cc3ddb343dfc734dd4e760e06abdf733cb83371+SINGLE+EC+FR+2017-20180705073311+00+CARD_FRAUD=OK+1+12345678++++N+7+7++++2017-20180705073243+000730+AUTHORISED+a450413f9ec04fcc9c11b9f3b2103c2c+0+V2+YES+1111111111111111';
        $this->assertSame($expected, $response->getComputedSignature(false));

        // check signature for inconsistent data
        $inconsistentData = self::$acceptedPaymentData;
        $inconsistentData['vads_card_country'] = 'US';

        $response = new Response($inconsistentData, '1111111111111111', '2222222222222222', Util::ALGO_SHA1);
        $this->assertFalse($response->isAuthentified(), 'Authentication must fail.');

        // check signature for failed payment data
        $response = new Response(self::$failedPaymentData, '1111111111111111', '2222222222222222', Util::ALGO_SHA1);
        $this->assertTrue($response->isAuthentified(), 'Error in computed signature.');
    }

    public function testAuthenticatedSha256()
    {
        // check signature for accepted payment data
        $sha256Data = self::$acceptedPaymentData;
        $sha256Data['signature'] = '9sopoUOXohjFBpy3nKIxNSp+gQLESOG/P1P+voDIPkA=';
        $response = new Response($sha256Data, '1111111111111111', '2222222222222222', Util::ALGO_SHA256);

        $this->assertTrue($response->isAuthentified(), 'Error in computed signature.');

        $expected = 'INTERACTIVE+2525+FULL+3fe69a+00+17807+A+0+CB+FR+497010XXXXXX0001+5785350+TEST+978+test@test.com+2525+2017-20180705073311+978+6+2018+00+fr+DEBIT+ja-4013+PAYMENT+3cc3ddb343dfc734dd4e760e06abdf733cb83371+SINGLE+EC+FR+2017-20180705073311+00+CARD_FRAUD=OK+1+12345678++++N+7+7++++2017-20180705073243+000730+AUTHORISED+a450413f9ec04fcc9c11b9f3b2103c2c+0+V2+YES+1111111111111111';
        $this->assertSame($expected, $response->getComputedSignature(false));

        // check signature for inconsistent data
        $inconsistentData = $sha256Data;
        $inconsistentData['vads_card_country'] = 'US';

        $response = new Response($inconsistentData, '1111111111111111', '2222222222222222', Util::ALGO_SHA256);
        $this->assertFalse($response->isAuthentified(), 'Authentication must fail.');

        // check signature for failed payment data
        $sha256Data = self::$failedPaymentData;
        $sha256Data['signature'] = 'lBC3GGHikARqYXEXeClLrVieu1Xfwrn9a41otIRt52w=';

        $response = new Response($sha256Data, '1111111111111111', '2222222222222222', Util::ALGO_SHA256);
        $this->assertTrue($response->isAuthentified(), 'Error in computed signature.');
    }

    public function testAcceptedPayment()
    {
        $response = new Response(self::$acceptedPaymentData, '1111111111111111', '2222222222222222');

        $this->assertTrue($response->isAcceptedPayment());
        $this->assertFalse($response->isPendingPayment());
        $this->assertSame('AUTHORISED', $response->getTransStatus());
        $this->assertSame(25.25, $response->getFloatAmount());

        // check payment result
        $results = array(
            'result' => '00',
            'extra_result' => '00',
            'auth_result' => '00',
            'warranty_result' => 'YES'
        );
        $this->assertEquals($results, $response->getAllResults());

        // check fraud controls
        $this->assertFalse($response->isSuspectedFraud());

        $riskControl = $response->getRiskControl();
        $this->assertArrayHasKey('CARD_FRAUD', $riskControl);
        $this->assertSame('OK', $riskControl['CARD_FRAUD']);
        $this->assertEmpty($response->getRiskAssessment());
    }

    public function testFailedPayment()
    {
        $response = new Response(self::$failedPaymentData, 'TEST', '1111111111111111', '2222222222222222');

        $this->assertFalse($response->isAcceptedPayment());
        $this->assertFalse($response->isPendingPayment());
        $this->assertFalse($response->isCancelledPayment());
        $this->assertFalse($response->isToValidatePayment());
        $this->assertSame('REFUSED', $response->getTransStatus());
        $this->assertSame(88.94, $response->getFloatAmount());

        // check payment result
        $results = array(
            'result' => '05',
            'extra_result' => '00',
            'auth_result' => '05',
            'warranty_result' => ''
        );
        $this->assertEquals($results, $response->getAllResults());

        // check fraud controls
        $this->assertFalse($response->isSuspectedFraud());

        $riskControl = $response->getRiskControl();
        $this->assertArrayHasKey('CARD_FRAUD', $riskControl);
        $this->assertSame('OK', $riskControl['CARD_FRAUD']);
        $this->assertEmpty($response->getRiskAssessment());
    }

    public function testGetOutputForPlatform()
    {
        $response = new Response(self::$acceptedPaymentData, '1111111111111111', '2222222222222222');
        $response->setMerchantLanguage('en'); // responses will be translated to this language

        $msg = $response->getOutputForPlatform('payment_ok');
        $this->checkOutputFormat($msg, $response->get('trans_id'), true);
        $this->assertContains('Valid payment processed', $msg);

        $msg = $response->getOutputForPlatform('payment_ko');
        $this->checkOutputFormat($msg, $response->get('trans_id'), true);
        $this->assertContains('Invalid payment processed', $msg);

        $msg = $response->getOutputForPlatform('payment_ok_already_done');
        $this->checkOutputFormat($msg, $response->get('trans_id'), true);
        $this->assertContains('Valid payment processed, already saved', $msg);

        $msg = $response->getOutputForPlatform('auth_fail');
        $this->checkOutputFormat($msg, $response->get('trans_id'), false);
        $this->assertContains('Authentication failed', $msg);

        $msg = $response->getOutputForPlatform('order_not_found');
        $this->checkOutputFormat($msg, $response->get('trans_id'), false);
        $this->assertContains('Order not found', $msg);
    }

    private function checkOutputFormat($output, $transId, $success)
    {
        $this->assertContains('<span style="display:none">', $output);
        $this->assertContains("\n" . '</span>', $output);

        $regexp = $success ? "#>OK\-$transId#" : "#>KO\-$transId#";
        $this->assertRegexp($regexp, $output, 'Invalid output generated as response to IPN call.');
    }
}
