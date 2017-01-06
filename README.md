# emt-sdk-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An unofficial PHP SDK for Madrid's municipal bus company (EMT) OpenData API.

## Install

Via Composer

``` bash
$ composer require carlosafonso/emt-sdk-php
```

## Usage

You'll need a set of authentication credentials issued by the EMT OpenData team. These credentials can be obtained here: http://opendata.emtmadrid.es/Formulario.

Create an instance of the SDK client passing the credentials described above:

```php
$clientId = 'FOO.BAR.BAZ';
$passkey = 'ABCDEFGH-1234-ABCD-1234-ABCDEFGHIJKL'
$client = new Afonso\Emt\BusClient($clientId, $passkey);
```

Then call any of the available methods:

```php
$data = $client->getRouteLines([123], new \DateTime());
print_r($data);
```

Which should output something like this (truncated for readability):

```
Array
(
    [0] => stdClass Object
        (
            [line] => 123
            [secDetail] => 10
            [orderDetail] => 1
            [node] => 1425
            [distance] => 0
            [distancePreviousStop] => 0
            [name] => PZA.DE LEGAZPI-MAESTRO ARBOS
            [latitude] => 40.390813555735
            [longitude] => -3.6951516754786
        )

    [1] => stdClass Object
        (
            [line] => 123
            [secDetail] => 10
            [orderDetail] => 1
            [node] => 930
            [distance] => 839
            [distancePreviousStop] => 839
            [name] => ANTONIO LOPEZ-AV.CORDOBA
            [latitude] => 40.386984182818
            [longitude] => -3.6982344337479
        )
)
```

### Available methods

The current version of this library exposes all API endpoints from the BUS web service (http://opendata.emtmadrid.es/Servicios-web/BUS).

Additional services are expected to be implemented soon.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email carlos.afonso.perez@gmail.com instead of using the issue tracker.

## Credits

- [Carlos Afonso][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/carlosafonso/emt-sdk-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/carlosafonso/emt-sdk-php/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/carlosafonso/emt-sdk-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/carlosafonso/emt-sdk-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/carlosafonso/emt-sdk-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/carlosafonso/emt-sdk-php
[link-travis]: https://travis-ci.org/carlosafonso/emt-sdk-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/carlosafonso/emt-sdk-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/carlosafonso/emt-sdk-php
[link-downloads]: https://packagist.org/packages/carlosafonso/emt-sdk-php
[link-author]: https://github.com/carlosafonso
[link-contributors]: ../../contributors
