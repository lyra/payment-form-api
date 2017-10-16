<?php
/**
 * This file is part of Lyra payment form API.
 * Copyright (C) Lyra Network.
 * See COPYING.txt for license details.
 */
namespace Lyranetwork;

class UtilTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateTransId()
    {
        $id = Util::generateTransId();
        $this->assertEquals(6, strlen($id), 'Generated transaction ID has more or less than 6 characters.');
        $this->assertTrue(is_numeric($id), 'Not numeric transaction ID generated.' );

        $time = strtotime('midnight');
        $id = Util::generateTransId($time);
        $this->assertTrue((int) $id < 10);

        $time = strtotime('today 23:59:59');
        $id = Util::generateTransId($time);
        $this->assertTrue((int) $id < 899999, 'Generated transaction ID is out of range.');
    }

    public function testSupportedLanguages()
    {
        $languages = Util::getSupportedLanguages();

        $this->assertTrue(is_array($languages));
        $this->assertTrue(count($languages) > 0);

        $keys = array_keys($languages);
        foreach ($keys as $key) {
            $this->assertRegExp('/^[a-z]{2}$/', $key, 'Invalid language ISO code.');
        }

        $this->assertTrue(Util::isSupportedLanguage('fr'));
        $this->assertFalse(Util::isSupportedLanguage('ppp'));
    }

    public function testSupportedCurrencies()
    {
        $currencies = Util::getSupportedCurrencies();

        $this->assertTrue(is_array($currencies));
        $this->assertTrue(count($currencies) > 0);

        foreach ($currencies as $currency) {
            $this->assertTrue(is_a($currency, '\Lyranetwork\Currency'));
        }

        // check currency queries
        $any = $currencies[0];

        $currency1 = Util::findCurrencyByAlphaCode($any->getAlpha3());
        $currency2 = Util::findCurrencyByNumCode($any->getNum());

        $this->assertEquals($currency1->getAlpha3(), $currency2->getAlpha3());
        $this->assertEquals($currency1->getNum(), $currency2->getNum());
        $this->assertEquals($currency1->getDecimals(), $currency2->getDecimals());

        $this->assertNull(Util::findCurrencyByAlphaCode('CURRENCY'), 'No currency should be found for the passed code.');

        $num = Util::getCurrencyNumCode($any->getAlpha3());
        $this->assertEquals($any->getNum(), $num);
    }

    public function testSupportedPaymentMeans()
    {
        $means = Util::getSupportedPaymentMeans();

        $this->assertTrue(is_array($means));
        $this->assertTrue(count($means) > 0);

        $keys = array_keys($means);
        foreach ($keys as $key) {
            $this->assertRegExp('/^[A-Za-z0-9\-_]+$/', $key, 'Invalid payment means code.');
        }
    }

    public function testSign()
    {
        $params = array(
            'signature' => '',
            'vads_action_mode' => 'INTERACTIVE',
            'vads_amount' => '3119',
            'vads_cust_address' => '20, rue des Tests Résidence Testée',
            'vads_cust_city' => 'Testville',
            'vads_cust_country' => 'FR',
            'vads_cust_email' => 'test.lyra@test.com',
            'vads_cust_first_name' => 'Test',
            'vads_cust_id' => '2',
            'vads_capture_delay' => '',
            'vads_contrib' => 'Test1.x_1.1.3/1.7.0.6/5.6.24',
            'vads_ctx_mode' => 'TEST',
            'vads_currency' => '978',
            'vads_cust_last_name' => 'Lyra',
            'vads_cust_phone' => '0787878787',
            'vads_cust_title' => 'M',
            'vads_trans_date' => '20170626132245',
            'vads_trans_id' => '553658',
            'vads_url_return' => 'http://www.mysite.com/return',
            'vads_validation_mode' => '',
            'vads_language' => 'fr',
            'vads_payment_config' => 'SINGLE',
            'vads_return_mode' => 'GET',
            'vads_ship_to_city' => 'Testville',
            'vads_cust_zip' => '13652',
            'vads_ship_to_street2' => 'Résidence Testée',
            'vads_ship_to_zip' => '13652',
            'vads_site_id' => '12345678',
            'vads_ship_to_country' => 'FR',
            'vads_ship_to_first_name' => 'Test',
            'vads_ship_to_last_name' => 'Lyra',
            'vads_ship_to_phone_num' => '0787878787',
            'vads_ship_to_street' => '20, rue des Tests',
            'vads_version' => 'V2',
            'vads_product_label0' => 'Robe imprimée',
            'vads_product_amount0' => '2599',
            'vads_nb_products' => '1',
            'vads_order_id' => '472',
            'vads_page_action' => 'PAYMENT',
            'vads_payment_cards' => '',
            'vads_product_qty0' => '1',
            'vads_product_ref0' => '3',
            'vads_product_type0' => 'CLOTHING_AND_ACCESSORIES'
        );

        $key = '1111111111111111';

        $this->assertEquals(
            'INTERACTIVE+3119++Test1.x_1.1.3/1.7.0.6/5.6.24+TEST+978+20, rue des Tests Résidence Testée+Testville+FR+test.lyra@test.com+Test+2+Lyra+0787878787+M+13652+fr+1+472+PAYMENT++SINGLE+2599+Robe imprimée+1+3+CLOTHING_AND_ACCESSORIES+GET+Testville+FR+Test+Lyra+0787878787+20, rue des Tests+Résidence Testée+13652+12345678+20170626132245+553658+http://www.mysite.com/return++V2+1111111111111111',
            Util::sign($params, $key, Util::ALGO_SHA1, false),
            'Invalid signature string computed.'
        );

        $this->assertEquals(
            'INTERACTIVE+3119++Test1.x_1.1.3/1.7.0.6/5.6.24+TEST+978+20, rue des Tests Résidence Testée+Testville+FR+test.lyra@test.com+Test+2+Lyra+0787878787+M+13652+fr+1+472+PAYMENT++SINGLE+2599+Robe imprimée+1+3+CLOTHING_AND_ACCESSORIES+GET+Testville+FR+Test+Lyra+0787878787+20, rue des Tests+Résidence Testée+13652+12345678+20170626132245+553658+http://www.mysite.com/return++V2+1111111111111111',
            Util::sign($params, $key, Util::ALGO_SHA256, false),
            'Invalid signature string computed.'
        );

        $this->assertEquals('84bebd03bf751abe00ba45867df8c39d2dd47294', Util::sign($params, $key, Util::ALGO_SHA1, true));
        $this->assertEquals('C05G1Tw7fXmVH44yQpNBtflpjyxqptUJYgw3hiodWns=', Util::sign($params, $key, Util::ALGO_SHA256, true));

        $this->assertEquals('84bebd03bf751abe00ba45867df8c39d2dd47294', Util::sign($params, $key, Util::ALGO_SHA1));
        $this->assertEquals('C05G1Tw7fXmVH44yQpNBtflpjyxqptUJYgw3hiodWns=', Util::sign($params, $key, Util::ALGO_SHA256));
    }

    public function testFindInArray()
    {
        $array = array(
            'first_name' => 'Test',
            'last_name' => 'Lyra',
            'street' => '20, rue des Tests',
            'street2' => 'Résidence Testée',
            'zip' => '13652',
            'city' => 'Testville',
            'country' => 'FR',
            'phone_num' => ''
        );

        $this->assertEquals('Test', Util::findInArray('first_name', $array, 'Default'));
        $this->assertEquals('Lyra', Util::findInArray('last_name', $array, 'Default'));
        $this->assertEquals('', Util::findInArray('phone_num', $array, 'Default'));
        $this->assertEquals('Default', Util::findInArray('unknown_key', $array, 'Default'));
    }
}
