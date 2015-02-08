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
 * Class CurrencyPair
 *
 * @package Keios\MoneyRight
 * @see http://en.wikipedia.org/wiki/Currency_pair
 */
class CurrencyPair
{
    /** @var Currency */
    private $baseCurrency;

    /** @var Currency */
    private $counterCurrency;

    /** @var string */
    private $ratio;

    /**
     * @param \Keios\MoneyRight\Currency $baseCurrency
     * @param \Keios\MoneyRight\Currency $counterCurrency
     * @param float                      $ratio
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function __construct(Currency $baseCurrency, Currency $counterCurrency, $ratio)
    {
        if (!is_numeric($ratio)) {
            throw new InvalidArgumentException(
                sprintf('Ratio must be numeric, %s of value %s given.', gettype($ratio), (string) $ratio)
            );
        }

        $this->counterCurrency = $counterCurrency;
        $this->baseCurrency = $baseCurrency;
        $this->ratio = Math::bcround((string) $ratio, Money::GAAP_PRECISION);
    }

    /**
     * @param string $iso String representation of the form "EUR/USD 1.2500"
     *
     * @throws \Exception
     * @return \Keios\MoneyRight\CurrencyPair
     */
    public static function createFromIso($iso)
    {
        $currency = "([A-Z]{2,3})";
        $ratio = "([0-9]*\.?[0-9]+)"; // @see http://www.regular-expressions.info/floatingpoint.html
        $pattern = '/'.$currency.'\/'.$currency.' '.$ratio.'/';

        $matches = [];
        if (!preg_match($pattern, $iso, $matches)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Can't create currency pair from ISO string '%s', format of string is invalid",
                    $iso
                )
            );
        }

        return new static(new Currency($matches[1]), new Currency($matches[2]), $matches[3]);
    }

    /**
     * @param \Keios\MoneyRight\Money $money
     * @param mixed                   $roundingMode
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     * @return \Keios\MoneyRight\Money
     */
    public function convert(Money $money, $roundingMode = Money::ROUND_HALF_UP)
    {
        if (!$money->getCurrency()->equals($this->baseCurrency)) {
            throw new InvalidArgumentException(
                sprintf('Currencies must match: Money to convert has currency %s, while CurrencyPair has base currency %s.',
                    $money->getCurrency()->getIsoCode(),
                    $this->baseCurrency->getIsoCode()
                )
            );
        }

        return new Money(
            Math::bcround(
                bcmul($money->getAmountString(), $this->ratio, Money::GAAP_PRECISION + 1),
                Money::GAAP_PRECISION,
                $roundingMode
            ),
            $this->counterCurrency
        );
    }

    /**
     * @return \Keios\MoneyRight\Currency
     */
    public function getCounterCurrency()
    {
        return $this->counterCurrency;
    }

    /**
     * @return \Keios\MoneyRight\Currency
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @param bool $usePrecision
     *
     * @return float
     */
    public function getRatio($usePrecision = false)
    {
        return $usePrecision ? bcadd($this->ratio, '0', Money::GAAP_PRECISION) : (float) $this->ratio;
    }
}