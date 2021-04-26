# Library | Voucher True Money Wallet - API
__ENGLISH__\
Before use you need to define ``use BossNz\TrueMoneyWallet\Voucher`` and then create an instance of ``Voucher`` If all of that is done you should write your code like below.
\
\
__THAILAND__\
ก่อนที่จะใช้ให้ท่านทำการเรียกใช้ ``use BossNz\TrueMoneyWallet\Voucher`` แล้วให้สร้างอ็อบเจ็กต์ที่ชื่อ ``Voucher`` ถ้าทำตามทุกขั้นตอนแล้วให้ทำการเขียนโค้ดตามลักษณะโค้ดข้างบนที่เป็นตัวอย่าง สามารถนำไปปรับแต่งหรือประยุกต์ได้ และอย่าลืมให้เครดิตการทำของ Contributor ด้วย
```php
<?php
    use BossNz\TrueMoneyWallet\Voucher; // Use namespace
    require 'path of lib file'; // call file library
    
    $instanceOfClass = new Voucher; // create an instance
    
    $phone = "your phone number"; // true money wallet number
    $voucher = "invite voucher"; // invite voucher hash
    $instanceOfClass->setUser([
        $instanceOfClass::INPUT_PHONE_TYPE      =>  $phone,
        $instanceOfClass::INPUT_VOUCHER_TYPE    =>  $voucher
    ]);
    $instanceOfClass->redeem(); // actions and give you a result
?>
```


### Thanks for first contributor
Original code by [bossNzXD](https://github.com/bossNzXD)
