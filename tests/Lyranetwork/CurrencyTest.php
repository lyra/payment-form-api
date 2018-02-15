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

class CurrencyTest extends \PHPUnit\Framework\TestCase
{

    private static $eur;

    private static $xpf;

    public static function setUpBeforeClass()
    {
        self::$eur = new Currency('EUR', '978', 2);
        self::$xpf = new Currency('XPF', '953', 0);
    }

    public function testConvertAmountToInteger()
    {
        // check conversion from decimal amount to cents for EUR currency (2 decimals)
        $this->assertEquals(2536, self::$eur->convertAmountToInteger(25.36));
        $this->assertEquals(2536, self::$eur->convertAmountToInteger(25.368));
        $this->assertEquals(2530, self::$eur->convertAmountToInteger(25.3));
        $this->assertEquals(2500, self::$eur->convertAmountToInteger(25));

        // check conversion from decimal amounts to cents for XPF currency (no decimals)
        $this->assertEquals(25, self::$xpf->convertAmountToInteger(25.36));
        $this->assertEquals(25, self::$xpf->convertAmountToInteger(25.9));
        $this->assertEquals(25, self::$xpf->convertAmountToInteger(25));
        $this->assertEquals(250, self::$xpf->convertAmountToInteger(250));
    }

    public function testConvertAmountToFloat()
    {
        // check conversion from cents to decimal amount for EUR currency (2 decimals)
        $this->assertEquals(0.25, self::$eur->convertAmountToFloat(25));
        $this->assertEquals(25, self::$eur->convertAmountToFloat(2500));
        $this->assertEquals(25.32, self::$eur->convertAmountToFloat(2532));
        $this->assertEquals(25.99, self::$eur->convertAmountToFloat(2599));

        // check conversion from cents to decimal amount for XPF currency (no decimals)
        $this->assertEquals(2536, self::$xpf->convertAmountToFloat(2536));
        $this->assertEquals(259, self::$xpf->convertAmountToFloat(259));
        $this->assertEquals(25, self::$xpf->convertAmountToFloat(25));
        $this->assertEquals(250, self::$xpf->convertAmountToFloat(250));
    }
}
