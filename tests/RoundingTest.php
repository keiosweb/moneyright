<?php namespace Keios\MoneyRight\Test;

use Keios\MoneyRight\Math;
use Keios\MoneyRight\Money;

class RoundingTest extends \PHPUnit_Framework_TestCase{

    public function testBcRoundMethodRoundsHalfUpCorrectly() {
        // tie
        $this->assertEquals(0, bccomp((string)round(0.0000501, 4, PHP_ROUND_HALF_UP), Math::bcround('0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000501, 4, PHP_ROUND_HALF_UP), Math::bcround('-0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(0.00005, 4, PHP_ROUND_HALF_UP), Math::bcround('0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00005, 4, PHP_ROUND_HALF_UP), Math::bcround('-0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(0.00501, 2, PHP_ROUND_HALF_UP), Math::bcround('0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00501, 2, PHP_ROUND_HALF_UP), Math::bcround('-0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_UP), 4));
        // up
        $this->assertEquals(0, bccomp((string)round(0.00008434534, 4, PHP_ROUND_HALF_UP), Math::bcround('0.00008434534', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000765763, 4, PHP_ROUND_HALF_UP), Math::bcround('-0.0000765763', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(0.006076576, 2, PHP_ROUND_HALF_UP), Math::bcround('0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_UP), 2));
        $this->assertEquals(0, bccomp((string)round(-0.006076576, 2, PHP_ROUND_HALF_UP), Math::bcround('-0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_UP), 2));
        // down
        $this->assertEquals(0, bccomp((string)round(0.000134534, 4, PHP_ROUND_HALF_UP), Math::bcround('0.000134534', Money::GAAP_PRECISION, Money::ROUND_HALF_UP)), 4);
        $this->assertEquals(0, bccomp((string)round(-0.000134234, 4, PHP_ROUND_HALF_UP), Math::bcround('-0.000134234', Money::GAAP_PRECISION, Money::ROUND_HALF_UP), 4));
        $this->assertEquals(0, bccomp((string)round(0.01154076576, 2, PHP_ROUND_HALF_UP), Math::bcround('0.01154076576', Money::BASIC_PRECISION, Money::ROUND_HALF_UP), 2));
        $this->assertEquals(0, bccomp((string)round(-0.0146076576, 2, PHP_ROUND_HALF_UP), Math::bcround('-0.0146076576', Money::BASIC_PRECISION, Money::ROUND_HALF_UP), 2));
    }

    public function testBcRoundMethodRoundsHalfDownCorrectly() {
        // tie
        $this->assertEquals(0, bccomp((string)round(0.0000501, 4, PHP_ROUND_HALF_DOWN), Math::bcround('0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000501, 4, PHP_ROUND_HALF_DOWN), Math::bcround('-0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(0.00005, 4, PHP_ROUND_HALF_DOWN), Math::bcround('0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00005, 4, PHP_ROUND_HALF_DOWN), Math::bcround('-0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(0.00501, 2, PHP_ROUND_HALF_DOWN), Math::bcround('0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00501, 2, PHP_ROUND_HALF_DOWN), Math::bcround('-0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_DOWN), 4));
        // up
        $this->assertEquals(0, bccomp((string)round(0.00008434534, 4, PHP_ROUND_HALF_DOWN), Math::bcround('0.00008434534', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000765763, 4, PHP_ROUND_HALF_DOWN), Math::bcround('-0.0000765763', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(0.006076576, 2, PHP_ROUND_HALF_DOWN), Math::bcround('0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_DOWN), 2));
        $this->assertEquals(0, bccomp((string)round(-0.006076576, 2, PHP_ROUND_HALF_DOWN), Math::bcround('-0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_DOWN), 2));
        // down
        $this->assertEquals(0, bccomp((string)round(0.000134534, 4, PHP_ROUND_HALF_DOWN), Math::bcround('0.000134534', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN)), 4);
        $this->assertEquals(0, bccomp((string)round(-0.000134234, 4, PHP_ROUND_HALF_DOWN), Math::bcround('-0.000134234', Money::GAAP_PRECISION, Money::ROUND_HALF_DOWN), 4));
        $this->assertEquals(0, bccomp((string)round(0.01154076576, 2, PHP_ROUND_HALF_DOWN), Math::bcround('0.01154076576', Money::BASIC_PRECISION, Money::ROUND_HALF_DOWN), 2));
        $this->assertEquals(0, bccomp((string)round(-0.0146076576, 2, PHP_ROUND_HALF_DOWN), Math::bcround('-0.0146076576', Money::BASIC_PRECISION, Money::ROUND_HALF_DOWN), 2));
    }

    public function testBcRoundMethodRoundsHalfEvenCorrectly() {
        // tie
        $this->assertEquals(0, bccomp((string)round(0.0000501, 4, PHP_ROUND_HALF_EVEN), Math::bcround('0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000501, 4, PHP_ROUND_HALF_EVEN), Math::bcround('-0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(0.00005, 4, PHP_ROUND_HALF_EVEN), Math::bcround('0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00005, 4, PHP_ROUND_HALF_EVEN), Math::bcround('-0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(0.00501, 2, PHP_ROUND_HALF_EVEN), Math::bcround('0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00501, 2, PHP_ROUND_HALF_EVEN), Math::bcround('-0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_EVEN), 4));
        // up
        $this->assertEquals(0, bccomp((string)round(0.00008434534, 4, PHP_ROUND_HALF_EVEN), Math::bcround('0.00008434534', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000765763, 4, PHP_ROUND_HALF_EVEN), Math::bcround('-0.0000765763', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(0.006076576, 2, PHP_ROUND_HALF_EVEN), Math::bcround('0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_EVEN), 2));
        $this->assertEquals(0, bccomp((string)round(-0.006076576, 2, PHP_ROUND_HALF_EVEN), Math::bcround('-0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_EVEN), 2));
        // down
        $this->assertEquals(0, bccomp((string)round(0.000134534, 4, PHP_ROUND_HALF_EVEN), Math::bcround('0.000134534', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN)), 4);
        $this->assertEquals(0, bccomp((string)round(-0.000134234, 4, PHP_ROUND_HALF_EVEN), Math::bcround('-0.000134234', Money::GAAP_PRECISION, Money::ROUND_HALF_EVEN), 4));
        $this->assertEquals(0, bccomp((string)round(0.01154076576, 2, PHP_ROUND_HALF_EVEN), Math::bcround('0.01154076576', Money::BASIC_PRECISION, Money::ROUND_HALF_EVEN), 2));
        $this->assertEquals(0, bccomp((string)round(-0.0146076576, 2, PHP_ROUND_HALF_EVEN), Math::bcround('-0.0146076576', Money::BASIC_PRECISION, Money::ROUND_HALF_EVEN), 2));
    }

    public function testBcRoundMethodRoundsHalfOddCorrectly() {
        // tie
        $this->assertEquals(0, bccomp((string)round(0.0000501, 4, PHP_ROUND_HALF_ODD), Math::bcround('0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000501, 4, PHP_ROUND_HALF_ODD), Math::bcround('-0.0000501', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(0.00005, 4, PHP_ROUND_HALF_ODD), Math::bcround('0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00005, 4, PHP_ROUND_HALF_ODD), Math::bcround('-0.00005', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(0.00501, 2, PHP_ROUND_HALF_ODD), Math::bcround('0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(-0.00501, 2, PHP_ROUND_HALF_ODD), Math::bcround('-0.00501', Money::BASIC_PRECISION, Money::ROUND_HALF_ODD), 4));
        // up
        $this->assertEquals(0, bccomp((string)round(0.00008434534, 4, PHP_ROUND_HALF_ODD), Math::bcround('0.00008434534', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(-0.0000765763, 4, PHP_ROUND_HALF_ODD), Math::bcround('-0.0000765763', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(0.006076576, 2, PHP_ROUND_HALF_ODD), Math::bcround('0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_ODD), 2));
        $this->assertEquals(0, bccomp((string)round(-0.006076576, 2, PHP_ROUND_HALF_ODD), Math::bcround('-0.006076576', Money::BASIC_PRECISION, Money::ROUND_HALF_ODD), 2));
        // down
        $this->assertEquals(0, bccomp((string)round(0.000134534, 4, PHP_ROUND_HALF_ODD), Math::bcround('0.000134534', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD)), 4);
        $this->assertEquals(0, bccomp((string)round(-0.000134234, 4, PHP_ROUND_HALF_ODD), Math::bcround('-0.000134234', Money::GAAP_PRECISION, Money::ROUND_HALF_ODD), 4));
        $this->assertEquals(0, bccomp((string)round(0.01154076576, 2, PHP_ROUND_HALF_ODD), Math::bcround('0.01154076576', Money::BASIC_PRECISION, Money::ROUND_HALF_ODD), 2));
        $this->assertEquals(0, bccomp((string)round(-0.0146076576, 2, PHP_ROUND_HALF_ODD), Math::bcround('-0.0146076576', Money::BASIC_PRECISION, Money::ROUND_HALF_ODD), 2));
    }
} 