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
use JsonSerializable;
use Keios\MoneyRight\Exceptions\InvalidArgumentException;
use Serializable;

/**
 * Class Money
 * Money Value Object
 *
 * @package Keios\MoneyRight
 */
class Money implements Serializable, JsonSerializable
{

    /**
     * @const
     */
    const GAAP_PRECISION = 4;

    /**
     * @const
     */
    const BASIC_PRECISION = 2;

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
     * @var string
     */
    private $amount;

    /**
     * @var \Keios\MoneyRight\Currency
     */
    private $currency;

    /**
     * Create a new Money Instance
     *
     * @param string                     $amount
     * @param \Keios\MoneyRight\Currency $currency
     */
    public function __construct($amount, Currency $currency)
    {
        if (is_int($amount)) {
            $amount = $amount / 100;
        }

        $stringAmount = $this->castValueToString($amount);

        $this->currency = $currency;
        $this->bootWith($stringAmount);
    }

    /**
     * Convenience factory method for an Keios\MoneyRight\Money object
     *
     * @example $fiveDollar = Money::USD(500);
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return \Keios\MoneyRight\Money
     */
    public static function __callStatic($method, $arguments)
    {
        return new Money($arguments[0], new Currency($method));
    }

    // SERIALIZATION

    /**
     * Serialization of Money value object
     *
     * @return string
     */
    public function serialize()
    {
        return serialize([
            'amount'   => $this->amount,
            'currency' => serialize($this->currency),
        ]);
    }

    /**
     * Unserializing Money value object
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);

        $this->amount = $unserialized['amount'];
        $this->currency = unserialize($unserialized['currency']);
    }

    /**
     * @return string
     */
    public function jsonserialize()
    {
        return [
            'amount'   => $this->amount,
            'currency' => $this->currency->jsonserialize(),
        ];
    }

    // GETTERS

    /**
     * Return full GAAP precision amount string
     *
     * @return string
     */
    public function getAmountString()
    {
        return $this->amount;
    }

    /**
     * Compatibility with Verraes' Money
     *
     * @return integer
     */
    public function getAmount()
    {
        return (integer) bcmul('100', Math::bcround($this->amount, self::BASIC_PRECISION));
    }

    /**
     * @return \Keios\MoneyRight\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    // LOGIC

    /**
     * @param \Keios\MoneyRight\Money
     *
     * @return bool
     */
    public function greaterThan(Money $other)
    {
        return 1 == $this->compare($other);
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return bool
     */
    public function greaterThanOrEqual(Money $other)
    {
        return 0 >= $this->compare($other);
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return bool
     */
    public function lessThan(Money $other)
    {
        return -1 == $this->compare($other);
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return bool
     */
    public function lessThanOrEqual(Money $other)
    {
        return 0 <= $this->compare($other);
    }

    /**
     * Compatibility with Verraes' Money
     *
     * @deprecated Use getAmount() instead
     * @return int
     */
    public function getUnits()
    {
        return $this->amount;
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return bool
     */
    public function isSameCurrency(Money $other)
    {
        return $this->currency->equals($other->getCurrency());
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return bool
     */
    public function equals(Money $other)
    {
        return $this->isSameCurrency($other) && $this->isSameAmount($other);
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return int
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function compare(Money $other)
    {
        $this->assertSameCurrency($other);

        return bccomp($this->amount, $other->getAmountString(), self::GAAP_PRECISION);
    }

    /**
     * @param \Keios\MoneyRight\Money $addend
     *
     * @return \Keios\MoneyRight\Money
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function add(Money $addend)
    {
        $this->assertSameCurrency($addend);

        return new Money(bcadd($this->amount, $addend->getAmountString(), self::GAAP_PRECISION), $this->currency);
    }

    /**
     * @param \Keios\MoneyRight\Money $subtrahend
     *
     * @return \Keios\MoneyRight\Money
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function subtract(Money $subtrahend)
    {
        $this->assertSameCurrency($subtrahend);

        return new Money(bcsub($this->amount, $subtrahend->getAmountString(), self::GAAP_PRECISION), $this->currency);
    }

    /**
     * Multiplying compatible with Verraes' Money
     * To use GAAP precision rounding, pass true as third argument
     *
     * @param      $operand
     * @param int  $roundingMode
     * @param bool $useGaapPrecision
     *
     * @return \Keios\MoneyRight\Money
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function multiply($operand, $roundingMode = self::ROUND_HALF_UP, $useGaapPrecision = false)
    {
        $this->assertOperand($operand);

        $validatedOperand = $this->normalizeOperand($operand);

        if ($useGaapPrecision) {
            $amount = Math::bcround(
                bcmul($this->amount, $validatedOperand, self::GAAP_PRECISION + 1),
                self::GAAP_PRECISION,
                $roundingMode
            );
        } else {
            $amount = Math::bcround(
                bcmul($this->amount, $validatedOperand, self::GAAP_PRECISION + 1),
                self::BASIC_PRECISION,
                $roundingMode
            );
        }

        return new Money($amount, $this->currency);
    }

    /**
     * Division compatible with Verraes' Money
     * To use GAAP precision rounding, pass true as third argument
     *
     * @param      $operand
     * @param int  $roundingMode
     * @param bool $useGaapPrecision
     *
     * @return \Keios\MoneyRight\Money
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function divide($operand, $roundingMode = self::ROUND_HALF_UP, $useGaapPrecision = false)
    {
        $this->assertOperand($operand, true);

        $validatedOperand = $this->normalizeOperand($operand);

        if ($useGaapPrecision) {
            $amount = Math::bcround(
                bcdiv($this->amount, $validatedOperand, self::GAAP_PRECISION + 1),
                self::GAAP_PRECISION,
                $roundingMode
            );
        } else {
            $amount = Math::bcround(
                bcdiv($this->amount, $validatedOperand, self::GAAP_PRECISION + 1),
                self::BASIC_PRECISION,
                $roundingMode
            );
        }

        return new Money($amount, $this->currency);
    }

    /**
     * Allocate the money according to a list of ratio's
     * Allocation is compatible with Verraes' Money
     * To use GAAP precision rounding, pass true as second argument
     *
     * @param array $ratios           List of ratio's
     * @param bool  $useGaapPrecision
     *
     * @return array
     */
    public function allocate(array $ratios, $useGaapPrecision = false)
    {
        $useGaapPrecision ? $precision = self::GAAP_PRECISION : $precision = self::BASIC_PRECISION;

        $remainder = $this->amount;
        $results = [];
        $total = array_sum($ratios);

        foreach ($ratios as $ratio) {
            $share = bcdiv(
                bcmul(
                    $this->amount,
                    (string) $ratio,
                    $precision
                ),
                (string) $total,
                $precision
            );
            $results[] = new Money($share, $this->currency);
            $remainder = bcsub($remainder, $share, $precision);
        }

        $count = count($results) - 1;
        $index = 0;
        $minValue = '0.'.str_repeat('0', $precision - 1).'1';

        while (bccomp($remainder, '0'.str_repeat('0', $precision), $precision) !== 0) {
            $remainder = bcsub($remainder, $minValue, $precision);
            $results[$index] = $results[$index]->add(new Money($minValue, $this->currency));
            if ($index !== $count) {
                $index++;
            } else {
                $index = 0;
            }
        }

        return $results;
    }

    /**
     * @return bool
     */
    public function isZero()
    {
        return bccomp('0', $this->amount, self::GAAP_PRECISION) === 0;
    }

    /**
     * @return bool
     */
    public function isPositive()
    {
        return bccomp($this->amount, '0', self::GAAP_PRECISION) === 1;
    }

    /**
     * @return bool
     */
    public function isNegative()
    {
        return bccomp($this->amount, '0', self::GAAP_PRECISION) === -1;
    }

    // INTERNALS

    /**
     * @param mixed $value
     *
     * @return string
     */
    private function castValueToString($value)
    {
        return (string) $value;
    }

    /**
     * @param $stringAmount
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    private function bootWith($stringAmount)
    {
        $this->assertValidAmountString($stringAmount);
        $this->amount = $this->normalizeAmountFromString($stringAmount);
    }

    /**
     * @param $string
     *
     * @return string
     */
    private function normalizeString($string)
    {
        return str_replace(',', '.', $string);
    }

    /**
     * @param $operand
     *
     * @return mixed
     */
    private function normalizeOperand($operand)
    {
        return $this->normalizeString($this->castValueToString($operand));
    }

    /**
     * @param $stringAmount
     *
     * @return string
     */
    private function normalizeAmountFromString($stringAmount)
    {
        $normalizedAmount = $this->normalizeString($stringAmount);

        return Math::bcround($normalizedAmount, self::GAAP_PRECISION);
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @return bool
     */
    private function isSameAmount(Money $other)
    {
        return bccomp($this->getAmountString(), $other->getAmountString(), self::GAAP_PRECISION) === 0;
    }

    // ASSERTIONS

    /**
     * @param $stringAmount
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    private function assertValidAmountString($stringAmount)
    {
        if (!is_numeric($this->normalizeString($stringAmount))) {
            throw new InvalidArgumentException(sprintf('Value %s is not a valid money amount.', $stringAmount));
        }
    }

    /**
     * @param $stringOperand
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    private function assertValidOperandString($stringOperand)
    {
        if (!is_numeric($this->normalizeString($stringOperand))) {
            throw new InvalidArgumentException(sprintf('Value %s is not a valid operand.', $stringOperand));
        }
    }

    /**
     * @param \Keios\MoneyRight\Money $other
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    private function assertSameCurrency(Money $other)
    {
        if (!$this->isSameCurrency($other)) {
            throw new InvalidArgumentException(sprintf('Cannot add Money with different currency. Have: %s, given: %s.',
                    $this->currency->getIsoCode(), $other->getCurrency()->getIsoCode())
            );
        }
    }

    /**
     * @param int|float $operand
     * @param bool      $isDivision
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    private function assertOperand($operand, $isDivision = false)
    {
        if (!is_int($operand) && !is_float($operand) && !is_string($operand)) {
            throw new InvalidArgumentException(sprintf('Operand should be a string, integer or a float, %s of value %s given.',
                    gettype($operand), (string) $operand)
            );
        }

        $this->assertValidOperandString($this->castValueToString($operand));

        if ($isDivision) {
            $this->assertOperandNotZero($operand);
        }
    }

    /**
     * @param $operand
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    private function assertOperandNotZero($operand)
    {
        $normalizedOperand = $this->normalizeOperand($operand);
        if ($normalizedOperand === '0' || $normalizedOperand === '-0') {
            throw new InvalidArgumentException('Division by zero.');
        }
    }

    // STATIC METHODS

    /**
     * @param $string
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     * @return int
     */
    public static function stringToUnits($string)
    {
        new Money($string, new Currency('USD')); // TODO optimize?

        return (int) bcmul($string, '100', self::GAAP_PRECISION);
    }
}
