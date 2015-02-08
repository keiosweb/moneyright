<?php namespace Keios\MoneyRight\Test;

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

use PHPUnit_Framework_TestCase;
use Keios\MoneyRight\Currency;

class CurrencyTest extends PHPUnit_Framework_TestCase
{

    const EURO_ISO_CODE = 'EUR';
    const PLN_ISO_CODE = 'PLN';

    public $euro1;
    public $euro2;
    public $pln1;
    public $pln2;
    public $availableCurrencies;

    /**
     * SetUp
     */
    public function setUp()
    {
        $this->euro1 = new Currency('eur');
        $this->euro2 = new Currency('EUR');
        $this->pln1 = new Currency('pln');
        $this->pln2 = new Currency('PLN');
        $this->availableCurrencies = Currency::$currencies;
    }

    /**
     * @test
     */
    public function testCaseOfIsoCodeArgumentIsIrrelevant()
    {
        $this->assertTrue($this->euro1->getIsoCode() === self::EURO_ISO_CODE);
        $this->assertTrue($this->euro2->getIsoCode() === self::EURO_ISO_CODE);
        $this->assertTrue($this->pln1->getIsoCode() === self::PLN_ISO_CODE);
        $this->assertTrue($this->pln2->getIsoCode() === self::PLN_ISO_CODE);
    }

    /**
     * @test
     */
    public function testDifferentInstancesAreEqual()
    {
        $this->assertTrue($this->euro1->equals($this->euro2));
        $this->assertTrue($this->pln1->equals($this->pln2));
    }

    /**
     * @test
     */
    public function testDifferentCurrenciesAreNotEqual()
    {
        $this->assertFalse($this->euro1->equals($this->pln1));
    }

    /**
     * @test
     */
    public function testAllCurrenciesCanBeInstantiated()
    {
        $isoCodes = array_keys($this->availableCurrencies);
        foreach ($isoCodes as $isoCode) {
            $instance1 = new Currency($isoCode);
            $instance2 = new Currency($isoCode);
            $this->assertTrue($instance1->equals($instance2));
        }
    }

    /**
     * @test
     */
    public function testInstancesCanBeSerialized()
    {
        $serialized1 = serialize($this->euro1);
        $serialized2 = serialize($this->euro2);

        $unserialized1 = unserialize($serialized1);
        $unserialized2 = unserialize($serialized2);

        $this->assertTrue($unserialized1->equals($unserialized2));
    }

    /**
     * @test
     */
    public function testInstancesCanBeSerializedToValidJson()
    {
        $jsonSerialized = json_encode($this->euro1);
        $this->assertNotNull(json_decode($jsonSerialized));
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\UnknownCurrencyException
     */
    public function testCantInstantiateWithInvalidIsoCode()
    {
        new Currency('FFF');
    }
}
