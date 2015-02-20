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

use Serializable;
use JsonSerializable;
use Keios\MoneyRight\Exceptions\UnknownCurrencyException;

/**
 * Class Currency
 * Currency Value Object
 *
 * @package Keios\MoneyRight
 */
class Currency implements Serializable, JsonSerializable
{

    /**
     * @var array
     */
    public static $currencies;

    /**
     * @var string
     */
    protected $isoCode;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $symbol;

    /**
     * @var null|array
     */
    protected $alternateSymbols = null;

    /**
     * @var string
     */
    protected $subunit;

    /**
     * @var bool
     */
    protected $symbolFirst;

    /**
     * @var string
     */
    protected $htmlEntity;

    /**
     * @var string
     */
    protected $decimalMark;

    /**
     * @var string
     */
    protected $thousandsSeparator;

    /**
     * @var string
     */
    protected $isoNumeric;

    /**
     * @var null|string
     */
    protected $disambiguateSymbol = null;

    /**
     * Currency constructor
     *
     * @param string $isoCode
     *
     * @throws \Keios\MoneyRight\Exceptions\UnknownCurrencyException
     */
    public function __construct($isoCode)
    {
        $this->prepareCurrencies();

        $isoCode = strtolower($isoCode);

        if (!array_key_exists($isoCode, self::$currencies)) {
            throw new UnknownCurrencyException('Currency with '.$isoCode.' iso code does not exist!');
        }

        $currentCurrency = self::$currencies[$isoCode];

        $this->fill($currentCurrency);
    }

    /**
     * Load currency data from JSON configuration and cache it in static property
     */
    protected function prepareCurrencies()
    {
        if (!self::$currencies) {
            self::$currencies = self::loadCurrencies();
        }
    }

    /**
     * Protected setter for all fields
     *
     * @param array $data
     */
    protected function fill(array $data)
    {
        $this->isoCode = $data['iso_code'];
        $this->name = $data['name'];
        $this->symbol = $data['symbol'];
        $this->subunit = $data['subunit'];
        $this->symbolFirst = $data['symbol_first'];
        $this->htmlEntity = $data['html_entity'];
        $this->decimalMark = $data['decimal_mark'];
        $this->thousandsSeparator = $data['thousands_separator'];
        $this->isoNumeric = $data['iso_numeric'];

        if (array_key_exists('alternate_symbols', $data)) {
            $this->alternateSymbols = $data['alternate_symbols'];
        }

        if (array_key_exists('disambiguate_symbol', $data)) {
            $this->disambiguateSymbol = $data['disambiguate_symbol'];
        }
    }

    /**
     * Prepares data for serialization
     *
     * @return array
     */
    protected function aggregateData()
    {
        $data = [
            'iso_code'            => $this->isoCode,
            'name'                => $this->name,
            'symbol'              => $this->symbol,
            'subunit'             => $this->subunit,
            'symbol_first'        => $this->symbolFirst,
            'html_entity'         => $this->htmlEntity,
            'decimal_mark'        => $this->decimalMark,
            'thousands_separator' => $this->thousandsSeparator,
            'iso_numeric'         => $this->isoNumeric,
        ];

        if (!is_null($this->alternateSymbols)) {
            $data['alternate_symbols'] = $this->alternateSymbols;
        }

        if (!is_null($this->disambiguateSymbol)) {
            $data['disambiguate_symbol'] = $this->disambiguateSymbol;
        }

        return $data;
    }

    /*
     * GETTERS
     */

    /**
     * Getter for currency iso code
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * @return string
     */
    public function getDecimalMark()
    {
        return $this->decimalMark;
    }

    /**
     * @return null|array
     */
    public function getAlternateSymbols()
    {
        return $this->alternateSymbols;
    }

    /**
     * @return null|string
     */
    public function getDisambiguateSymbol()
    {
        return $this->disambiguateSymbol;
    }

    /**
     * @return string
     */
    public function getHtmlEntity()
    {
        return $this->htmlEntity;
    }

    /**
     * @return string
     */
    public function getIsoNumeric()
    {
        return $this->isoNumeric;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSubunit()
    {
        return $this->subunit;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return bool
     */
    public function getSymbolFirst()
    {
        return $this->symbolFirst;
    }

    /**
     * @return string
     */
    public function getThousandsSeparator()
    {
        return $this->thousandsSeparator;
    }

    /*
     * LOGIC
     */

    /**
     * Checks if this Currency object is equal to another Currency object
     *
     * @param \Keios\MoneyRight\Currency $other
     *
     * @return bool
     */
    public function equals(Currency $other)
    {
        return $this->isoCode === $other->getIsoCode();
    }

    /**
     * Serialization getter for \Serializable
     *
     * @return string
     */
    public function serialize()
    {
        $data = $this->aggregateData();

        return serialize($data);
    }

    /**
     * Serialization constructor for \Serializable
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->prepareCurrencies();
        $unserialized = unserialize($serialized);
        $this->fill($unserialized);
    }

    /**
     * JSON Serialization getter for \JsonSerializable
     *
     * @return string
     */
    public function jsonserialize()
    {
        $data = $this->aggregateData();

        return $data;
    }

    /**
     * Loads currency config from JSON files
     * @return array
     */
    public static function loadCurrencies()
    {
        return array_merge(
            json_decode(file_get_contents(__DIR__.'/config/currency_iso.json'), true),
            json_decode(file_get_contents(__DIR__.'/config/currency_non_iso.json'), true)
        );
    }
}