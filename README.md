# PHP MNB (Magyar Nemzeti Bank)

## Requirements
This package requires **SoapClient** and **PHP 7.1** or higher.

## Note on behavior
MNB Soap client only supports HUF base currency. So the API will return with the well calculated exchange rates based on HUF.

# Usage

## Initialize
```php
require 'vendor/autoload.php';
$client = new \SzuniSoft\Mnb\Client();
```
## Access list of currencies
Returns with string array. Each element is a currency code.
```php
$currencies = $client->currencies(); // HUF, EUR, ...
```

## Determine currency existence
```php
$client->hasCurrency('EUR'); // true
```

## List of current currency exchange rates
Each element of the returned array will be an instance of **_SzuniSoft\Mnb\Model\Currency_**
```php
$exchangeRates = $client->currenctExchangeRates($date);

$exchangeRates[0]->getCode(); // EUR
$exchangeRates[0]->getUnit(); // 1
$exchangeRates[0]->getAmount(); // 300
```

## Obtain exchange rate for specific currency
The returned value will be an instance of **_SzuniSoft\Mnb\Model\Currency_**
```php
$currency = $client->currentExchangeRate('EUR');
```

## SoapClient proxy
Client has proxy method call which will invoke the desired method on the _**SoapClient**_ directly.
```php
$client->{'AnyMethodYouWishToInvoke'}();
```