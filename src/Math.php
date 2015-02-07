<?php namespace Keios\MoneyRight;

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
     * Round decimals from 5 up, less than 5 down
     *
     * @param $sign
     * @param $number
     * @param $precision
     *
     * @return string
     */
    final private static function bcRoundHalfUp($sign, $number, $precision)
    {
        if (strpos($number, '.') === false) {
            return bcadd($number, '0', $precision);
        }

        $halfUpValue = $sign . '0.' . str_repeat('0', $precision) . '5';
        $number = bcadd($number, $halfUpValue, $precision + 1);

        return bcadd($number, '0', $precision);
    }

    /**
     * Round decimals from 6 up, less than 6 down
     *
     * @param $sign
     * @param $number
     * @param $precision
     *
     * @return string
     */
    final private static function bcRoundHalfDown($sign, $number, $precision)
    {
        if (strpos($number, '.') === false) {
            return bcadd($number, '0', $precision);
        }

        $decimals = explode('.', $number)[1];
        $halfUpValue = $sign . '0.' . str_repeat('0', $precision) . '5';
        $firstDecimalAfterPrecision = (int)substr($decimals, $precision, 1);

        if ($firstDecimalAfterPrecision === self::HALF) {
            $remainingDecimals = substr($decimals, $precision + 1);
            if (bccomp($remainingDecimals, '0', 64) === 1) {
                $result = bcadd($number, $halfUpValue, $precision + 1);
            } else {
                $result = $number;
            }
        } else {
            if ($firstDecimalAfterPrecision > self::HALF) {
                $result = bcadd($number, $halfUpValue, $precision + 1);
            } else {
                $result = $number;
            }
        }

        return bcadd($result, '0', $precision);
    }

    /**
     * Round on half towards nearest even number on $precision - 1 position
     *
     * @param $sign
     * @param $number
     * @param $precision
     *
     * @return string
     */
    final private static function bcRoundHalfEven($sign, $number, $precision)
    {
        if (strpos($number, '.') === false) {
            return bcadd($number, '0', $precision);
        }

        list($integers, $decimals) = explode('.', $number);
        $halfUpValue = $sign . '0.' . str_repeat('0', $precision) . '5';
        $firstDecimalAfterPrecision = (int)substr($decimals, $precision, 1);

        if ($firstDecimalAfterPrecision === self::HALF) {

            $remainingDecimals = substr($decimals, $precision + 1);

            if (bccomp($remainingDecimals, '0', 64) === 1) {

                $result = bcadd($number, $halfUpValue, $precision + 1);
                
            } else {
                if ($precision === 0) {
                    $evenOddDigit = (int)substr($integers, -1);
                } else {
                    $evenOddDigit = (int)$decimals[$precision - 1];
                }

                if ($evenOddDigit % 2) { // odd
                    $result = bcadd($number, $halfUpValue, $precision + 1);
                } else { // even
                    $result = $number;
                }

            }
        } else {

            if ($firstDecimalAfterPrecision > self::HALF) {
                $result = bcadd($number, $halfUpValue, $precision + 1);
            } else {
                $result = $number;
            }
        }

        return bcadd($result, '0', $precision);
    }

    /**
     * Round on half towards nearest odd number on $precision - 1 position
     *
     * @param $sign
     * @param $number
     * @param $precision
     *
     * @return string
     */
    final private static function bcRoundHalfOdd($sign, $number, $precision)
    {
        if (strpos($number, '.') === false) {
            return bcadd($number, '0', $precision);
        }

        list($integers, $decimals) = explode('.', $number);
        $halfUpValue = $sign . '0.' . str_repeat('0', $precision) . '5';
        $firstDecimalAfterPrecision = (int)substr($decimals, $precision, 1);

        if ($firstDecimalAfterPrecision === self::HALF) {

            $remainingDecimals = substr($decimals, $precision + 1);

            if (bccomp($remainingDecimals, '0', 64) === 1) {

                $result = bcadd($number, $halfUpValue, $precision + 1);

            } else {

                if ($precision === 0) {
                    $evenOddDigit = (int)substr($integers, -1);
                } else {
                    $evenOddDigit = (int)$decimals[$precision - 1];
                }

                if ($evenOddDigit % 2) { // odd
                    $result = $number;
                } else { // even
                    $result = bcadd($number, $halfUpValue, $precision + 1);
                }
            }
        } else {

            if ($firstDecimalAfterPrecision > self::HALF) {
                $result = bcadd($number, $halfUpValue, $precision + 1);
            } else {
                $result = $number;
            }
        }

        return bcadd($result, '0', $precision);
    }

    /**
     * Round wrapper
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
        if ($precision < 0) {
            $precision = 0;
        }

        $sign = '';

        if (bccomp('0', $number, 64) == 1) {
            $sign = '-';
        }

        switch ($roundingMode) {
            case self::ROUND_HALF_UP:
                $retVal = self::bcRoundHalfUp($sign, $number, $precision);
                break;
            case self::ROUND_HALF_DOWN:
                $retVal = self::bcRoundHalfDown($sign, $number, $precision);
                break;
            case self::ROUND_HALF_EVEN:
                $retVal = self::bcRoundHalfEven($sign, $number, $precision);
                break;
            case self::ROUND_HALF_ODD:
                $retVal = self::bcRoundHalfOdd($sign, $number, $precision);
                break;
            default:
                throw new InvalidArgumentException('Rounding mode should be Money::ROUND_HALF_DOWN | Money::ROUND_HALF_EVEN | Money::ROUND_HALF_ODD | Money::ROUND_HALF_UP');
        }

        /*
         * Arbitrary precision arithmetic allows for '-0.0' which is not equal to '0.0' if compared with bccomp.
         * We have no use for this behaviour, so negative numbers have to be checked if they are minus zero,
         * so we can convert them into unsigned zero and return that.
         */
        if ($retVal[0] === '-') {
            $strippedSign = substr($retVal, 1);
            if (bccomp($strippedSign, '0', $precision) === 0) {
                $retVal = '0';
            };
        }

        return $retVal;
    }
}
