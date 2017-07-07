<?php
/**
 * This file is part of Lyra payment form API.
 * Copyright (C) Lyra Network.
 * See COPYING.txt for license details.
 */
namespace Lyranetwork;

/**
 * Utility class for managing parameters checking, inetrnationalization, signature building and more.
 */
class Util
{

    /**
     * The list of encodings supported by the API.
     *
     * @var array[string]
     */
    public static $SUPPORTED_ENCODINGS = array(
        'UTF-8',
        'ASCII',
        'Windows-1252',
        'ISO-8859-15',
        'ISO-8859-1',
        'ISO-8859-6',
        'CP1256'
    );

    private static $cache = array();

    private function __construct()
    {
        // do not instanciate this class
    }

    /**
     * Generate a trans_id.
     * To be independent from shared/persistent counters, we use the number of 1/10 seconds since midnight
     * which has the appropriatee format (000000-899999) and has great chances to be unique.
     *
     * @param int $timestamp
     * @return string the generated trans_id
     */
    public static function generateTransId($timestamp = null)
    {
        if (! $timestamp) {
            $timestamp = time();
        }

        $parts = explode(' ', microtime());
        $id = ($timestamp + $parts[0] - strtotime('today 00:00')) * 10;
        $id = sprintf('%06d', $id);

        return $id;
    }

    /**
     * Returns an array of languages accepted by the payment platform.
     *
     * @return array[string][string]
     */
    public static function getSupportedLanguages()
    {
        if (! isset(self::$cache['languages'])) {
            self::$cache['languages'] = array();

            $xml = simplexml_load_file(__DIR__ . '/config/languages.xml');
            foreach ($xml->language as $language) {
                self::$cache['languages'][(string) $language['code']] = (string) $language['label'];
            }
        }

        return self::$cache['languages'];
    }

    /**
     * Returns true if the entered language (ISO code) is supported.
     *
     * @param string $lang
     * @return boolean
     */
    public static function isSupportedLanguage($lang)
    {
        foreach (array_keys(self::getSupportedLanguages()) as $code) {
            if ($code == strtolower($lang)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return the list of currencies recognized by the payment platform.
     *
     * @return array[int][Currency]
     */
    public static function getSupportedCurrencies()
    {
        if (! isset(self::$cache['currencies'])) {
            self::$cache['currencies'] = array();

            $xml = simplexml_load_file(__DIR__ . '/config/currencies.xml');
            foreach ($xml->currency as $currency) {
                self::$cache['currencies'][] = new Currency(
                    (string) $currency['alpha3'],
                    (string) $currency['num'],
                    (string) $currency['decimals']
                );
            }
        }

        return self::$cache['currencies'];
    }

    /**
     * Return a currency from its 3-letters ISO code.
     *
     * @param string $alpha3
     * @return Currency
     */
    public static function findCurrencyByAlphaCode($alpha3)
    {
        $list = self::getSupportedCurrencies();
        foreach ($list as $currency) {
            /**
             * @var Currency $currency
             */
            if ($currency->getAlpha3() == $alpha3) {
                return $currency;
            }
        }

        return null;
    }

    /**
     * Returns a currency form its numeric ISO code.
     *
     * @param int $numeric
     * @return Currency
     */
    public static function findCurrencyByNumCode($numeric)
    {
        $list = self::getSupportedCurrencies();
        foreach ($list as $currency) {
            /**
             * @var Currency $currency
             */
            if ($currency->getNum() == $numeric) {
                return $currency;
            }
        }

        return null;
    }

    /**
     * Return a currency from its 3-letters or numeric ISO code.
     *
     * @param string $code
     * @return Currency
     */
    public static function findCurrency($code)
    {
        $list = self::getSupportedCurrencies();
        foreach ($list as $currency) {
            /**
             * @var Currency $currency
             */
            if ($currency->getNum() == $code || $currency->getAlpha3() == $code) {
                return $currency;
            }
        }

        return null;
    }

    /**
     * Returns currency numeric ISO code from its 3-letters code.
     *
     * @param string $alpha3
     * @return int
     */
    public static function getCurrencyNumCode($alpha3)
    {
        $currency = self::findCurrencyByAlphaCode($alpha3);
        return ($currency instanceof Currency) ? $currency->getNum() : null;
    }

    /**
     * Returns an array of payment means accepted by the payment platform.
     *
     * @return array[string][string]
     */
    public static function getSupportedPaymentMeans()
    {
        if (! isset(self::$cache['payments'])) {
            self::$cache['payments'] = array();

            $xml = simplexml_load_file(__DIR__ . '/config/payments.xml');
            foreach ($xml->payment as $payment) {
                self::$cache['payments'][(string) $payment['code']] = (string) $payment['label'];
            }
        }

        return self::$cache['payments'];
    }

    /**
     * Compute payment signature. Parameters must be in UTF-8.
     *
     * @param array[string][string] $parameters
     * @param string $key
     * @param boolean $hashed
     * @return string
     */
    public static function sign($parameters, $key, $hashed = true)
    {
        ksort($parameters);

        $sign = '';
        foreach ($parameters as $name => $value) {
            if (substr($name, 0, 5) == 'vads_') {
                $sign .= $value . '+';
            }
        }

        $sign .= $key;
        return $hashed ? sha1($sign) : $sign;
    }

    /**
     * PHP is not yet a sufficiently advanced technology to be indistinguishable from magic...
     * so don't use magic_quotes, they mess up with the platform response analysis.
     *
     * @param array $potentially_quoted_data
     * @return mixed
     */
    public static function uncharm($potentially_quoted_data)
    {
        if (get_magic_quotes_gpc()) {
            $sane = array();
            foreach ($potentially_quoted_data as $k => $v) {
                $sane_key = stripslashes($k);
                $sane_value = is_array($v) ? self::uncharm($v) : stripslashes($v);
                $sane[$sane_key] = $sane_value;
            }
        } else {
            $sane = $potentially_quoted_data;
        }

        return $sane;
    }

    public static function findInArray($key, $array, $default)
    {
        if (is_array($array) && key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}
