# Keios/MoneyRight

[![Latest Version](https://img.shields.io/github/release/keiosweb/moneyright.svg?style=flat-square)](https://github.com/keiosweb/moneyright/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/keiosweb/moneyright/master.svg?style=flat-square)](https://travis-ci.org/keiosweb/moneyright)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/keiosweb/moneyright.svg?style=flat-square)](https://scrutinizer-ci.com/g/keiosweb/moneyright/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/keiosweb/moneyright.svg?style=flat-square)](https://scrutinizer-ci.com/g/keiosweb/moneyright)
[![Total Downloads](https://img.shields.io/packagist/dt/keiosweb/moneyright.svg?style=flat-square)](https://packagist.org/packages/keiosweb/moneyright)

Arbitrary precision arithmetic-based Money value object. Drop-in replacement for [Mathias Verraes'](https://github.com/mathiasverraes) Money library (some use statement tweaking required).
Follows [GAAP](http://en.wikipedia.org/wiki/Generally_accepted_accounting_principles) suggestion to use 4 decimal places with rounding on 5th to minimize statistical influence of rounding errors.

Follows PSR-2 guidelines.

## Requirements
PHP 5.4.0+
BCMath Arbitrary Precision Arithmetic PHP extension

## Install

Via Composer

``` bash
$ composer require keiosweb/moneyright
```

## Usage

``` php
$tenEuroNetPrice = Keios\MoneyRight\Money::EUR('10'); // Money::EUR(10000) integers as cents | Money::EUR(10.0) floats as literal amount

var_dump($tenEuroNetPrice->getAmount()); // int(1000) - cents
var_dump($tenEuroNetPrice->getAmountString()); // string(7) "10.0000" - literal amount in string with 4 decimal points precision

$vatTax = $tenEuroNetPrice->multiply('0.23'); // 23% VAT tax

var_dump(assert(!$vatTax->equals($tenEuroNetPrice))); // bool(true)
var_dump($vatTax->getAmountString()); // string(6) "2.3000"

$grossPrice = $tenEuroNetPrice->add($vatTax); // instances are immutable, so every operation returns new instance

var_dump($grossPrice->getAmountString()); // string(7) "12.3000"
var_dump($grossPrice->getAmount()); // int(1230) - cents

```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Keios Solutions](https://github.com/keiosweb)
- [Mathias Verraes](https://github.com/mathiasverraes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
