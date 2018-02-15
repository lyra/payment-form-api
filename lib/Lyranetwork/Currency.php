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
 * Class representing a currency, used for converting alpha/numeric ISO codes and float/integer amounts.
 */
class Currency
{

    private $alpha3;

    private $num;

    private $decimals;

    public function __construct($alpha3, $num, $decimals = 2)
    {
        $this->alpha3 = $alpha3;
        $this->num = $num;
        $this->decimals = $decimals;
    }

    public function convertAmountToInteger($float)
    {
        $coef = pow(10, $this->decimals);

        $amount = $float * $coef;
        return (int) (string) $amount; // cast amount to string (to avoid rounding) than return it as int
    }

    public function convertAmountToFloat($integer)
    {
        $coef = pow(10, $this->decimals);

        return ((float) $integer) / $coef;
    }

    public function getAlpha3()
    {
        return $this->alpha3;
    }

    public function getNum()
    {
        return $this->num;
    }

    public function getDecimals()
    {
        return $this->decimals;
    }
}
