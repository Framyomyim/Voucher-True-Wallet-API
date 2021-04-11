# Library | Voucher True Money Wallet - API
Before use you need to define ``use BossNz\TrueMoneyWallet\Voucher`` and then create an instance of ``Voucher`` If all of that are done you should write your code like below.
```php
<?php
    use BossNz\TrueMoneyWallet\Voucher; // Use namespace
    require 'path of lib file'; // call file library
    
    $instanceOfClass = new Voucher; // create an instance
    
    $phone = "your phone number"; // true money wallet number
    $voucher = "invite voucher"; // link invite voucher
    $instanceOfClass->redeem($phone, $voucher); // actions and given you a result
?>
```
