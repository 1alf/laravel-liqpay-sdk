# laravel-liqpay-sdk
Liqpay SDK for Laravel

#Install
```
composer require 1alf/laravel-liqpay-sdk

php artisan vendor:publish --provider="ALF\LiqPay\LiqPayServiceProvider"
```

# Using
You can use Laravel resolving and add LiqPay inside constructor
```php
public function __construct(LiqPay $liqpay)
{
    parent::__construct();
    $this->liqpay = $liqpay;
}
```
or you can use it directly
```php
$liqPay = new LiqPay('public_key', 'private_key');
try {
    $res = $liqPay->getApiClient()->request([
        'action'         => 'p2pcredit',
        'amount'         => '1',
        'currency'       => 'UAH',
        'description'    => 'description text',
        'order_id'       => '123456',
        'receiver_card'  => '4242424242424242',
        'receiver_last_name'  => 'LastName',
        'receiver_first_name'  => 'FirstName'
    ]);
    
    print_r($res);
} catch (BadResponseException $e) {
    echo $e->getMessage();
}
```
