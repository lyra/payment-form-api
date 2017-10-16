# Lyra payment form API

Lyra payment form API is an open source PHP SDK that allows integration of secured payment gateway developped by [Lyra Network](https://www.lyra-network.com/) inside e-commerce websites.

## Requirements

PHP 5.3.0 and later.

## Installation

### Composer 

You can install the API via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require lyranetwork/payment-form-api
```

To use the API, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

### Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/payzen/payment-form-api/releases). Then, to use the API, include the `init.php` file.

```php
require_once('/path/to/payment-form-api/init.php');
```

## Usage

To create payment form do : 

```php
$ctxMode = 'TEST';
$keyTest = '1111111111111111';
$keyProd = '2222222222222222';
$algo = 'SHA-1';

$request = new \Lyranetwork\Request();
$request->set('ctx_mode', $ctxMode);
$request->set('key_test', $keyTest);
$request->set('key_prod', $keyProd);
$request->set('sign_algo', $algo);


$request->set('site_id', '12345678');
$request->set('amount', '100'); // amount in cents
$request->set('currency', '978');
$request->set('capture_delay', 0);
$request->set('validation_mode', 0);

echo $request->getRequestHtmlForm();
```

To process payment result, do : 

```php
$keyTest = '1111111111111111';
$keyProd = '2222222222222222';
$algo = 'SHA-1';

$response = new \LyraNetwork\Response($_REQUEST, $keyTest, $keyProd, $algo);

if (! $response->isAuthentified()) {
    // Unauthenticated response received
    die('Authentication failed !');
}

$order = get_my_order($response->get('order_id'));

if ($response->isAcceptedPayment()) {
    // update order status, reduce products stock, send customer notifications, ...
    update_my_order($order, 'success');

    // redirect to success page
} elseif ($response->isCancelledPayment()) {
    // redirect to cart page
} else {
     // failed payment logic here
     update_my_order($order, 'failed');

    // redirect to failure or cart page
}
```

## License

Each Lyra payment form API source file included in this distribution is licensed under GNU GENERAL PUBLIC LICENSE (GPL 3.0).

Please see LICENSE.txt for the full text of the GPL 3.0 license. It is also available through the world-wide-web at this URL: http://www.gnu.org/licenses/.
