<?php namespace Keios\MoneyRight\Test;

use PHPUnit_Framework_TestCase;
use Keios\MoneyRight\Money;
use Keios\MoneyRight\Currency;
use Keios\MoneyRight\CurrencyPair;
use \Keios\MoneyRight\Exceptions\InvalidArgumentException;

class CurrencyPairTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testConvertsEurToUsdAndBack()
    {
        $eur = Money::EUR(100);

        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), '1.2500');
        $usd = $pair->convert($eur);
        $this->assertEquals(Money::USD(125), $usd);

        $pair = new CurrencyPair(new Currency('USD'), new Currency('EUR'), '0.8000');
        $eur = $pair->convert($usd);
        $this->assertEquals(Money::EUR(100), $eur);
    }

    /**
     * @test
     */
    public function testConvertsEurToUsdAndBackWithPrecision()
    {
        $eur = Money::EUR('1.2345');

        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), '1.2576343');
        $usd = $pair->convert($eur);
        $this->assertEquals(Money::USD('1.5525'), $usd);

        $pair = new CurrencyPair(new Currency('USD'), new Currency('EUR'), '0.7952423');
        $eur = $pair->convert($usd);
        $this->assertEquals(Money::EUR('1.2345'), $eur);
    }

    /**
     * @test
     */
    public function testParsesIso()
    {
        $pair = CurrencyPair::createFromIso('EUR/USD 1.2500');
        $expected = new CurrencyPair(new Currency('EUR'), new Currency('USD'), '1.2500');
        $this->assertEquals($expected, $pair);
    }

    /**
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Can't create currency pair from ISO string '1.2500', format of string is invalid
     */
    public function testParsesIsoWithException()
    {
        CurrencyPair::createFromIso('1.2500');
    }

    /**
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     *
     * @param string $nonNumericRatio
     *
     * @throws \Keios\MoneyRight\Exceptions\InvalidArgumentException
     *
     * @dataProvider             provideNonNumericRatio
     */
    public function testConstructorWithNonNumericRatio($nonNumericRatio)
    {
        try {
            new CurrencyPair(new Currency('EUR'), new Currency('USD'), $nonNumericRatio);
        } catch (InvalidArgumentException $ex) {
            $this->assertEquals($ex->getMessage(),
                sprintf('Ratio must be numeric, string of value %s given.', $nonNumericRatio));
            throw $ex;
        }
    }

    /**
     * @test
     */
    public function testGetRatio()
    {
        $ratio = 1.2500;
        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), $ratio);

        $this->assertEquals($ratio, $pair->getRatio());
    }

    /**
     * @test
     */
    public function testGetPreciseRatio()
    {
        $ratio = '1.25231446345';
        $expectedRatio = '1.2523';
        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), $ratio);

        $this->assertEquals($expectedRatio, $pair->getRatio(true));
    }

    /**
     * @test
     */
    public function testGetBaseCurrency()
    {
        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), '1.2500');

        $this->assertEquals(new Currency('EUR'), $pair->getBaseCurrency());
    }

    /**
     * @test
     */
    public function testGetCounterCurrency()
    {
        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), 1.2500);

        $this->assertEquals(new Currency('USD'), $pair->getCounterCurrency());
    }

    /**
     * @expectedException \Keios\MoneyRight\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Currencies must match: Money to convert has currency JPY, while CurrencyPair has base currency EUR.
     */
    public function testConvertWithInvalidCurrency()
    {
        $money = new Money(100, new Currency('JPY'));
        $pair = new CurrencyPair(new Currency('EUR'), new Currency('USD'), 1.2500);

        $pair->convert($money);
    }

    public function provideNonNumericRatio()
    {
        return [
            ['NonNumericRatio'],
            ['16AlsoIncorrect'],
            ['10.00ThisIsToo']
        ];
    }
}
