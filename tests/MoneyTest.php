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

use Keios\MoneyRight\Currency;
use Keios\MoneyRight\Money;

/**
 * Class MoneyTest
 *
 * @package Keios\MoneyRight\Test
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{

    const UP = Money::ROUND_HALF_UP;

    const DOWN = Money::ROUND_HALF_DOWN;

    const EVEN = Money::ROUND_HALF_EVEN;

    const ODD = Money::ROUND_HALF_ODD;

    /**
     * @var \Keios\MoneyRight\Currency
     */
    public $currency1;

    /**
     * @var \Keios\MoneyRight\Currency
     */
    public $currency2;

    /**
     * @var \Keios\MoneyRight\Money
     */
    public $money1;

    /**
     * @var \Keios\MoneyRight\Money
     */
    public $money2;

    /**
     * @var \Keios\MoneyRight\Money
     */
    public $money3;

    /**
     * Set Up Tests
     */
    public function setUp()
    {
        $this->currency1 = new Currency('pln');
        $this->currency2 = new Currency('usd');
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function testCantInstantiateWithInvalidString()
    {
        new Money('1,000.0001', $this->currency1);
    }

    /**
     * @test
     */
    public function testCanBeInstantiatedWithDotSeparatedValue()
    {
        $this->money1 = new Money('10.1', $this->currency1);
        $this->assertEquals(0, bccomp($this->money1->getAmountString(), '10.1000', 4));
    }

    /**
     * @test
     */
    public function testCanBeInstantiatedWithCommaSeparatedValue()
    {
        $this->money1 = new Money('10,1', $this->currency1);
        $this->assertEquals(0, bccomp($this->money1->getAmountString(), '10.1000', 4));
    }

    /**
     * @test
     */
    public function testCanBeInstantiatedWithDotBasedValue()
    {
        $this->money1 = new Money('.1456', $this->currency1);
        $this->assertEquals(0, bccomp($this->money1->getAmountString(), '0.1456', 4));
    }

    /**
     * @test
     */
    public function testCanBeInstantiatedWithCommaBasedValue()
    {
        $this->money1 = new Money(',1230', $this->currency1);
        $this->assertEquals(0, bccomp($this->money1->getAmountString(), '0.1230', 4));
    }

    /**
     * @test
     */
    public function testCanBeInstantiatedWithStaticCurrencyMethod()
    {
        $this->money1 = Money::PlN('50.1234'); // intentional lowercase letter, no difference for us
        $this->assertEquals(0, bccomp($this->money1->getAmountString(), '50.1234', 4));
        $this->assertEquals('PLN', $this->money1->getCurrency()->getIsoCode());
    }

    /**
     * @test
     */
    public function testGetAmountIsCompatibleWithVerraesMoney()
    {
        $this->money1 = Money::USD('50.1234');
        $this->assertEquals(5012, $this->money1->getAmount());
    }

    /**
     * @test
     */
    public function testInstantiationIsCompatibleWithVerraesMoney()
    {
        /*
         * 1 dollar as 100 cents like in Verraes Money class
         * Instantiation with integers is treated as an amount of cents
         * Instantiation with strings and floats is treated as literals,
         * so Money::USD('1.05') equals to 1 dollar 5 cents
         */
        $this->money1 = Money::USD(100);
        $this->money2 = Money::USD('1');
        $this->money3 = Money::USD(1.0);
        $this->assertEquals(100, $this->money1->getAmount());
        $this->assertTrue($this->money1->equals($this->money2));
        $this->assertTrue($this->money1->equals($this->money3));
    }

    /**
     * @test
     */
    public function testInstancesOfSameAmountAndCurrencyAreEqual()
    {
        $this->money1 = new Money('10.1234567890', $this->currency1);
        $this->money2 = new Money('10.1234567890', $this->currency1);
        $this->assertTrue($this->money1->equals($this->money2));
    }

    /**
     * @test
     */
    public function testInstancesOfDifferentAmountAndCurrencyAreNotEqual()
    {
        $this->money1 = new Money('10.1234567890', $this->currency1);
        $this->money2 = new Money('5.1234567890', $this->currency1);
        $this->assertFalse($this->money1->equals($this->money2));
    }

    /**
     * @test
     */
    public function testInstancesOfSameAmountAndDifferentCurrencyAreNotEqual()
    {
        $this->money1 = new Money('10.1234567890', $this->currency1);
        $this->money2 = new Money('10.1234567890', $this->currency2);
        $this->assertFalse($this->money1->equals($this->money2));
    }

    /**
     * @test
     */
    public function testComparingInstances()
    {
        $this->money1 = new Money('10.1234', $this->currency1);
        $this->money2 = new Money(10.1234, $this->currency1);
        $this->assertEquals(0, $this->money1->compare($this->money2));
        $this->money2 = new Money(10.1233, $this->currency1);
        $this->assertEquals(1, $this->money1->compare($this->money2));
        $this->money2 = new Money(10.1235, $this->currency1);
        $this->assertEquals(-1, $this->money1->compare($this->money2));
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function testDifferentCurrenciesCannotBeCompared()
    {
        Money::EUR(1)->compare(Money::USD(1));
    }

    /**
     * @test
     */
    public function testAllocatePreciseYieldsCorrectResults()
    {
        $this->money1 = new Money('10', $this->currency1);
        $results = $this->money1->allocate([3, 3, 3]);
        $results2 = $this->money1->allocate([3, 3, 3], true);
        $this->assertEquals(334, $results[0]->getAmount());
        $this->assertEquals(0, bccomp($results2[0]->getAmountString(), '3.3334', 4));
    }

    /**
     * @test
     */
    public function testAbsYieldsCorrectResults()
    {
        $this->money1 = new Money('2.3456789', $this->currency1);
        $this->money2 = new Money('2.3456789', $this->currency1);
        $this->money3 = new Money('-2.3456789', $this->currency1);

        $this->assertTrue($this->money1->equals($this->money2->abs()));
        $this->assertTrue($this->money1->equals($this->money3->abs()));
    }

    /**
     * @test
     */
    public function testAddingInstancesWithSameCurrencyYieldsCorrectResults()
    {
        $this->money1 = new Money('2.3456789', $this->currency1); // 2.3457
        $this->money2 = new Money(2.654321, $this->currency1); // 2.6543
        $newMoney = $this->money1->add($this->money2);
        $this->assertFalse($newMoney->equals($this->money1));
        $this->assertFalse($newMoney->equals($this->money2));
        $this->assertEquals(0, bccomp($newMoney->getAmountString(), '5.0000', 4));
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function testAddingInstancesWithDifferentCurrencyThrowsException()
    {
        $this->money1 = new Money('2.3456789', $this->currency1); // 2.3457
        $this->money2 = new Money('2.6543211', $this->currency2); // 2.6543
        $this->money1->add($this->money2);
    }

    /**
     * @test
     */
    public function testSubtractingInstancesWithSameCurrencyYieldsCorrectResults()
    {
        $this->money1 = new Money('7.6543211', $this->currency1); // 2.3457
        $this->money2 = new Money('2.6543211', $this->currency1); // 2.6543
        $newMoney = $this->money1->subtract($this->money2);
        $this->assertFalse($newMoney->equals($this->money1));
        $this->assertFalse($newMoney->equals($this->money2));
        $this->assertEquals(0, bccomp($newMoney->getAmountString(), '5.0000', 4));
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function testSubtractingInstancesWithDifferentCurrencyThrowsException()
    {
        $this->money1 = new Money('2.6543211', $this->currency1); // 2.3457
        $this->money2 = new Money('2.3456789', $this->currency2); // 2.6543
        $this->money1->subtract($this->money2);
    }

    /**
     * @test
     */
    public function testMultiplyingYieldsCorrectResults()
    {
        $this->money1 = new Money('2.3456789', $this->currency1); // 2.3457
        $this->money2 = $this->money1->multiply(3, Money::ROUND_HALF_UP, true);
        $this->assertFalse($this->money2->equals($this->money1));
        $this->assertEquals(0, bccomp($this->money2->getAmountString(), '7.0371', 4));
    }

    /**
     * @test
     */
    public function testDividingYieldsCorrectResults()
    {
        $this->money1 = new Money('10', $this->currency1); // 2.3457
        $this->money2 = $this->money1->divide(3, Money::ROUND_HALF_UP, true);
        $this->assertFalse($this->money2->equals($this->money1));
        $this->assertEquals(0, bccomp($this->money2->getAmountString(), '3.3333', 4));
    }

    /**
     * @test
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     */
    public function testDividingByZeroThrowsException()
    {
        $this->money1 = new Money('10', $this->currency1); // 2.3457
        $this->money1->divide(0);
    }

    /**
     * @test
     */
    public function testComparison()
    {
        $euro1 = new Money(1, new Currency('EUR'));
        $euro2 = new Money(2, new Currency('EUR'));
        $usd = new Money(1, new Currency('USD'));

        $this->assertTrue($euro2->greaterThan($euro1));
        $this->assertFalse($euro1->greaterThan($euro2));
        $this->assertTrue($euro1->lessThan($euro2));
        $this->assertFalse($euro2->lessThan($euro1));

        $this->assertEquals(-1, $euro1->compare($euro2));
        $this->assertEquals(1, $euro2->compare($euro1));
        $this->assertEquals(0, $euro1->compare($euro1));
    }

    /**
     * @test
     */
    public function testComparators()
    {
        $this->assertTrue(Money::EUR(0)->isZero());
        $this->assertTrue(Money::EUR(-1)->isNegative());
        $this->assertTrue(Money::EUR(1)->isPositive());
        $this->assertFalse(Money::EUR(1)->isZero());
        $this->assertFalse(Money::EUR(1)->isNegative());
        $this->assertFalse(Money::EUR(-1)->isPositive());
    }

    /**
     * @test
     */
    public function testSerialization()
    {
        $this->money1 = Money::PLN('1.2345');
        $serialized = serialize($this->money1);
        $unserialized = unserialize($serialized);
        $this->assertTrue($unserialized->equals($this->money1));
    }

}
