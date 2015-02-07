<?php
/**
 * This file is part of the Mathias Verraes' Money library
 * It was imported here for compatibility checks reasons
 * Minor changes were performed to port tests into Keios/MoneyRight package
 *
 * Copyright (c) 2011-2013 Mathias Verraes
 *
 * For the full copyright and license information, please view the LICENSE
 * file that is distributed with Mathias Verraes Money/Money package
 * https://github.com/mathiasverraes/money
 */

namespace Keios\MoneyRight\Test;

use PHPUnit_Framework_TestCase;
use Keios\MoneyRight\Currency;

class CompatibilityCurrencyTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->euro1 = new Currency('EUR');
        $this->euro2 = new Currency('EUR');
        $this->usd1 = new Currency('USD');
        $this->usd2 = new Currency('USD');
    }

    public function testDifferentInstancesAreEqual()
    {
        $this->assertTrue(
            $this->euro1->equals($this->euro2)
        );
        $this->assertTrue(
            $this->usd1->equals($this->usd2)
        );
    }

    public function testDifferentCurrenciesAreNotEqual()
    {
        $this->assertFalse(
            $this->euro1->equals($this->usd1)
        );
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\UnknownCurrencyException
     */
    public function testCantInstantiateUnknownCurrency()
    {
        new Currency('unknown');
    }
}
