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
namespace Lyranetwork;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    private static $configData = array();

    private static $cartData = array();

    public static function setUpBeforeClass()
    {
        self::$configData = array(
            'site_id' => '12345678',
            'key_test' => '1111111111111111',
            'key_prod' => '2222222222222222',
            'ctx_mode' => 'TEST',
            'platform_url' => 'https://secure.payzen.eu/vads-payment/',
            'language' => 'en',
            'available_languages' => 'en;fr;de',
            'payment_cards' => '',
            'capture_delay' => '',
            'validation_mode' => '0',
            'threeds_mpi' => null,
            'redirect_enabled' => false,
            'redirect_success_timeout' => '5',
            'redirect_success_message' => 'Redirection ...',
            'redirect_error_timeout' => '5',
            'redirect_error_message' => 'Redirection ...',
            'return_mode' => 'GET'
        );

        self::$cartData = array(
            'amount' => 2356,
            'contrib' => 'test1.x_1.1.2/1.5.5/5.6.3',
            'currency' => '978',
            'order_id' => 'ORD3536',
            'order_info' => 'Important order',

            // billing address info
            'cust_id' => 15,
            'cust_email' => 'test@test.com',
            'cust_first_name' => 'Test',
            'cust_last_name' => 'Lyra',
            'cust_address' => '20 Tests street',
            'cust_zip' => '31777',
            'cust_country' => 'FR',
            'cust_phone' => '0000000000',
            'cust_city' => 'Testcity',

            // shipping address info
            'ship_to_first_name' => 'Test',
            'ship_to_last_name' => 'Lyra',
            'ship_to_street' => '20 Tests street',
            'ship_to_street2' => '',
            'ship_to_city' => 'Testcity',
            'ship_to_country' => 'FR',
            'ship_to_zip' => '31777',
            'ship_to_phone_num' => '0000000000',

            // return URLs
            'url_return' => 'http://www.mysite.com/return'
        );
    }

    public function testSetData()
    {
        $request = new Request();

        $result = $request->setFromArray(self::$configData);
        $this->assertTrue((bool) $result, 'Error when trying to set request data from array.');

        foreach (self::$cartData as $key => $value) {
            $this->assertTrue((bool) $request->set($key, $value), "Error when trying to set [$value] for [$key] field.");
        }

        $errors = array();
        $request->isRequestReady($errors);
        $this->assertEmpty($errors, 'Validation errors occured : ' . print_r($errors, true));

        $data = array(
            'amount' => 23.56, // must be in cents
            'contrib' => 'test1.x_1.1.2/1.5.5/5.6.3',
            'currency' => 'EUR', // numeric code expected
            'order_id' => 'ORD/3536', // should not contain slash
            'order_info' => 'Important order'
        );
        $request->setFromArray($data);

        $errors = array();
        $request->isRequestReady($errors);

        $this->assertContains('vads_amount', $errors);
        $this->assertContains('vads_currency', $errors);
        $this->assertContains('vads_order_id', $errors);

        // check accented data
        $result = (bool) $request->set('cust_city', 'Crimée');
        $this->assertTrue($result);
        $this->assertSame('Crimée', $request->get('cust_city'));

        // use encoding conversion
        $request = new Request('ISO-8859-15');
        $request->set('cust_state', utf8_decode('Crimée')); // pass ISO-8859-15 encoded data
        $this->assertSame('Crimée', $request->get('cust_state'), 'Data not correctly converted to UTF-8.');
    }

    public function testSetMultiPayment()
    {
        $request = new Request();

        // check MULTI payment config with first payment amount
        $request->setMultiPayment(2536, 1000, 3, 30);
        $this->assertSame('MULTI:first=1000;count=3;period=30', $request->get('payment_config'));
        $this->assertEquals(2536, $request->get('amount'));

        // check MULTI payment config with no first payment amount
        $request->setMultiPayment(2536, null, 4, 30);
        $this->assertSame('MULTI:first=634;count=4;period=30', $request->get('payment_config'));
        $this->assertEquals(2536, $request->get('amount'));
    }

    public function testGetForm()
    {
        $request = new Request();
        $request->setFromArray(self::$configData);
        $request->setFromArray(self::$cartData);

        // use fixed transaction ID and date
        $request->set('trans_id', '344903');
        $request->set('trans_date', '20170628073450');

        $url = 'https://secure.payzen.eu/vads-payment/?signature=3ba916fbdd0081d186cc31462779aaac6aab1c82&vads_action_mode=INTERACTIVE&vads_amount=2356&vads_available_languages=en%3Bfr%3Bde&vads_capture_delay=&vads_contrib=test1.x_1.1.2%2F1.5.5%2F5.6.3&vads_ctx_mode=TEST&vads_currency=978&vads_cust_address=20%20Tests%20street&vads_cust_city=Testcity&vads_cust_country=FR&vads_cust_email=test%40test.com&vads_cust_first_name=Test&vads_cust_id=15&vads_cust_last_name=Lyra&vads_cust_phone=0000000000&vads_cust_zip=31777&vads_language=en&vads_order_id=ORD3536&vads_order_info=Important%20order&vads_page_action=PAYMENT&vads_payment_cards=&vads_payment_config=SINGLE&vads_return_mode=GET&vads_ship_to_city=Testcity&vads_ship_to_country=FR&vads_ship_to_first_name=Test&vads_ship_to_last_name=Lyra&vads_ship_to_phone_num=0000000000&vads_ship_to_state=63&vads_ship_to_street=20%20Tests%20street&vads_ship_to_street2=&vads_ship_to_zip=31777&vads_site_id=12345678&vads_trans_date=20170628073450&vads_trans_id=344903&vads_url_return=http%3A%2F%2Fwww.mysite.com%2Freturn&vads_validation_mode=0&vads_version=V2';
        $this->assertSame($url, $request->getRequestUrl());

        $form = $request->getRequestHtmlForm();
        $this->assertContains('<form action="https://secure.payzen.eu/vads-payment/" method="POST" >', $form,
            'No form header generated.');
        $this->assertContains('<input type="submit" value="Pay" />', $form, 'No form button generated.');
        $this->assertContains(
            '<input name="signature" value="3ba916fbdd0081d186cc31462779aaac6aab1c82" type="hidden" />', $form,
            'No signature field generated.');

        $pattern = '#^<input name="vads_[a-z0-9]+(_[a-z0-9]+)*" value="[^<>]*" type="hidden" />$#m';
        $count = preg_match_all($pattern, $form);
        $this->assertSame(38, $count, 'Some form fields are missing or invalid.');

        $fields = $request->getRequestArrayFields();
        $this->assertCount(39, $fields);
        $this->assertArrayHasKey('signature', $fields, 'Signature not found if fields array.');
        $this->assertEquals('3ba916fbdd0081d186cc31462779aaac6aab1c82', $fields['signature'],
            'Invalid signature generated.');

        foreach ($fields as $key => $value) {
            if ($key != 'signature') {
                $this->assertRegExp('/vads_[a-z0-9]+(_[a-z0-9]+)*/', $key, "Invalid name for field $key.");
            }
        }

        // check sensitive data masking
        $request->set('payment_cards', 'VISA');
        $request->set('card_number', '1111111111111111');
        $request->set('cvv', '111');
        $request->set('expiry_month', '03');
        $request->set('expiry_year', '2020');

        $fields = $request->getRequestArrayFields(true); // passed true to generate data for logging purpose
        $this->assertEquals('****************', $fields['vads_card_number'], 'Card number not masked well.');
        $this->assertEquals('***', $fields['vads_cvv'], 'CVV not masked well.');
        $this->assertEquals('**', $fields['vads_expiry_month'], 'Expiry month not masked well.');
        $this->assertEquals('****', $fields['vads_expiry_year'], 'Expiry year not masked well.');
    }
}
