# Library | Voucher True Money Wallet - API
Before use you need to define ``use BossNz\TrueMoneyWallet\Voucher`` and then create an instance of ``Voucher`` If all of that is done you should write your code like below.
```php
<?php
    use BossNz\TrueMoneyWallet\Voucher; // Use namespace
    require 'path of lib file'; // call file library
    
    $instanceOfClass = new Voucher; // create an instance
    
    $phone = "your phone number"; // true money wallet number
    $voucher = "invite voucher"; // link invite voucher
    $instanceOfClass->setUser([
        $instanceOfClass::INPUT_PHONE_TYPE      =>  $phone,
        $instanceOfVoucher::INPUT_VOUCHER_TYPE  =>  $voucher
    ]);
    $instanceOfClass->redeem(); // actions and give you a result
?>
```
