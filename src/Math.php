<?php namespace Keios\MoneyRight;

/**
 * This file is part of the arbitrary precision arithmetic-based
 * money value object Keios\MoneyRight package. Keios\MoneyRight
 * is heavily inspired by Mathias Verroes' Money library and was
 * designed to be a drop-in replacement (only some use statement
 * tweaking required) for mentioned library. Public APIs are
 * identical, functionality is extended with additional methods
 * and parameters.
 *
 *
 * Copyright (c) 2015 Łukasz Biały
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Keios\MoneyRight\Exceptions\InvalidArgumentException;

/**
 * Class Math
 * Provides arbitrary precision rounding using BCMath extension
 *
 * @package Keios\MoneyRight
 */
class Math
{
    /**
     * @const int HALF - rounding point
     */
    const HALF = 5;

    /**
     * @const
     */
    const ROUND_HALF_UP = PHP_ROUND_HALF_UP;

    /**
     * @const
     */
    const ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN;

    /**
     * @const
     */
    const ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN;

    /**
     * @const
     */
    const ROUND_HALF_ODD = PHP_ROUND_HALF_ODD;

    /**
     * @param $number
     * @param $precision
     * @return bool
     */
    final private static function isFirstDecimalAfterPrecisionTrailedByZeros($number, $precision)
    {
        $secondPlaceAfterPrecision = strpos($number, '.') + $precision + 2;
        $remainingDecimals = substr($number, $secondPlaceAfterPrecision);

        return bccomp($remainingDecimals, '0', 64) === 1;
    }

    /**
     * @param $number
     * @param $precision
     * @return string
     */
    final private static function getHalfUpValue($number, $precision)
    {
        $sign = self::getSign($number);;

        return $sign . '0.' . str_repeat('0', $precision) . '5';
    }

    /**
     * @param $number
     * @param $precision
     * @return string
     */
    final private static function truncate($number, $precision)
    {
        return bcadd($number, '0', $precision);
    }


    /**
     * @param $firstDecimalAfterPrecision
     * @param $number
     * @param $precision
     * @return string
     */
    final private static function roundNotTied($firstDecimalAfterPrecision, $number, $precision)
    {
        if ($firstDecimalAfterPrecision > self::HALF) {
            return self::bcRoundHalfUp($number, $precision);
        } else {
            return self::truncate($number, $precision);
        }
    }

    /**
     * @param $number
     * @param $precision
     * @param $roundingMode
     * @return string
     * @throws InvalidArgumentException
     */
    final private static function roundTied($number, $precision, $roundingMode)
    {
        if (self::isFirstDecimalAfterPrecisionTrailedByZeros($number, $precision)) {

            $result = self::bcRoundHalfUp($number, $precision);

        } else {
            switch ($roundingMode) {
                case self::ROUND_HALF_DOWN:
                    $result = self::truncate($number, $precision);
                    break;
                case self::ROUND_HALF_EVEN:
                    $result = self::getEvenRoundedResult($number, $precision);
                    break;
                case self::ROUND_HALF_ODD:
                    $result = self::getOddRoundedResult($number, $precision);
                    break;
                default:
                    throw new InvalidArgumentException('Rounding mode should be Money::ROUND_HALF_DOWN | Money::ROUND_HALF_EVEN | Money::ROUND_HALF_ODD | Money::ROUND_HALF_UP');
            }
        }

        return $result;
    }

    /**
     * @param $number
     * @return string
     */
    final private static function getSign($number)
    {
        if (bccomp('0', $number, 64) == 1) {
            return '-';
        } else {
            return '';
        }
    }

    /**
     * @param $number
     * @param $precision
     * @return int
     */
    final private static function getEvenOddDigit($number, $precision)
    {
        list($integers, $decimals) = explode('.', $number);
        if ($precision === 0) {
            return (int)substr($integers, -1);
        } else {
            return (int)$decimals[$precision - 1];
        }
    }

    /**
     * @param $number
     * @param $precision
     * @return string
     */
    final private static function getOddRoundedResult($number, $precision)
    {
        if (self::getEvenOddDigit($number, $precision) % 2) { // odd
            return self::truncate($number, $precision);
        } else { // even
            return self::truncate(self::bcRoundHalfUp($number, $precision), $precision);
        }

    }

    /**
     * @param $number
     * @param $precision
     * @return string
     */
    final private static function getEvenRoundedResult($number, $precision)
    {
        if (self::getEvenOddDigit($number, $precision) % 2) { // odd
            return self::bcRoundHalfUp($number, $precision);
        } else { // even
            return self::truncate($number, $precision);
        }

    }

    /**
     * @param $number
     * @param $precision
     * @return int
     */
    final private static function getFirstDecimalAfterPrecision($number, $precision)
    {
        $decimals = explode('.', $number)[1];
        $firstDecimalAfterPrecision = (int)substr($decimals, $precision, 1);

        return $firstDecimalAfterPrecision;
    }

    /**
     * Round decimals from 5 up, less than 5 down
     *
     * @param $number
     * @param $precision
     *
     * @return string
     */
    final private static function bcRoundHalfUp($number, $precision)
    {
        return self::truncate(bcadd($number, self::getHalfUpValue($number, $precision), $precision + 1), $precision);
    }

    /**
     * @param $precision
     * @return int
     */
    final private static function normalizePrecision($precision)
    {
        return ($precision < 0) ? 0 : $precision;
    }

    /**
     * @param $number
     * @return bool
     */
    final private static function isNotDecimalString($number)
    {
        return strpos($number, '.') === false;
    }

    /**
     * @param $result
     * @param $precision
     * @return string
     */
    final private static function normalizeZero($result, $precision)
    {
        if ($result[0] === '-') {
            if (bccomp(substr($result, 1), '0', $precision) === 0) {
                return '0';
            }
        }

        return $result;
    }

    /**
     * BCRound implementation
     *
     * @param     $number
     * @param     $precision
     * @param int $roundingMode
     *
     * @return string
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    final public static function bcround($number, $precision, $roundingMode = self::ROUND_HALF_UP)
    {
        $precision = self::normalizePrecision($precision);

        if (self::isNotDecimalString($number)) {
            return bcadd($number, '0', $precision);
        }

        if ($roundingMode === self::ROUND_HALF_UP) {
            return self::bcRoundHalfUp($number, $precision);
        }

        $firstDecimalAfterPrecision = self::getFirstDecimalAfterPrecision($number, $precision);

        if ($firstDecimalAfterPrecision === self::HALF) {
            $result = self::roundTied($number, $precision, $roundingMode);
        } else {
            $result = self::roundNotTied($firstDecimalAfterPrecision, $number, $precision);
        }

        /*
         * Arbitrary precision arithmetic allows for '-0.0' which is not equal to '0.0' if compared with bccomp.
         * We have no use for this behaviour, so negative numbers have to be checked if they are minus zero,
         * so we can convert them into unsigned zero and return that.
         */
        $result = self::normalizeZero($result, $precision);

        return $result;
    }
}
