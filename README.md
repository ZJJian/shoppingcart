##Comment
- Shopping cart add item, modify quantity, remove item and checkout
- User login, logout, user order.
- Order flow

## Requirements
> *PHP 7.4.27*
> 
> *Laravel 8.83.13*
>
> **Tools**
>
> *XAMPP 8.1.1-1vm*

## Environment

###Step1. install XAMPP

[MAC](https://sourceforge.net/projects/xampp/files/XAMPP%20Mac%20OS%20X/8.1.1/) xampp-osx-8.1.1-2-vm

[Windows](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.1.1/)

XAMPP DB連線設定請參考 [here](https://a091234765.pixnet.net/blog/post/403781468-%5B%E7%B6%B2%E9%A0%81%E6%8A%80%E5%B7%A7%E5%AD%B8%E7%BF%92%E7%AD%86%E8%A8%98%5Dxampp-mysql%E7%99%BB%E5%85%A5%E8%A8%AD%E7%BD%AE?fbclid=IwAR2I0cjMDDfkIJbpHOhqOS_0Y50oCpGIxNobapNItj4Y6rH697Hu99kNBGw)

請記住你的帳號密碼

###Step2. 在XMAPP/htdocs 資料夾下 clone code
```bash
git clone https://github.com/ZJJian/shoppingcart.git

cd XAMPP/htdocs/shoppingcart

vi .env
```
修改

```bash
DB_DATABASE=test   //安裝好XAMPP後內建的，若沒此DB請至http://127.0.0.1/phpmyadmin 建立一個DB並把名稱填入這欄位
DB_USERNAME=root   //Step1 AMPP中修改的帳號
DB_PASSWORD=  //Step1 AMPP中修改密碼
```

###Step3. install [composer](https://tony915.gitbooks.io/laravel4/content/install/install_composer.html)

###Step4. setup code
```bash
cd XAMPP/htdocs/shoppingcart

composer install
```
可以下以下指令檢查是否安裝成功
```bash
php artisan --version
```
安裝成功後請執行以下指令，建DB table
```bash
php artisan migrate:install

php artisan migrate
```
完成後DB內應該會有以下資料表

| Table Name | Comment                                   | 
|------------|-------------------------------------------|
|addresses      | 紀錄訂單地址，使用者可能收件地址不同，因此地址是跟隨訂單。內含個資因此有做加密處理 |
|failed_jobs| 系統原生，後續實作QUEUE時會使用到                       |
|generated_order_id| 紀錄產生過的order_id避免order_id重複                |
|migrations| 紀錄系統DB的操作檔案                               |
|orders| 紀錄訂單                                      |
|order_lines| 紀錄訂單商品內容                                  |
|products| 紀錄產品與庫存                                   |
|users| 使用者，使用者密碼有做加密處理                           |



###Step5. 啟動serve
```bash
php artisan optimize;

php artisan serve;
```


## File Path

```
shoppingcart  
└───app
│   └───Helpers
│   │       └─── Helpers.php
│   │ 
│   └───Http
│   │   └───Controllers
│   │       └───Auth
│   │       │   │    LoginController.php
│   │       │   └─── RegisterController.php
│   │       │    CartController.php
│   │       │    CheckoutController.php
│   │       │    ShopController.php
│   │       └─── UserController.php
│   │ 
│   └───Models
│   │   │    Addresses.php 
│   │   │    GeneratedOrderId.php 
│   │   │    OrderLines.php 
│   │   │    Orders.php  
│   │   │    Products.php 
│   │   └─── User.php
│   └───Services
│       └───Cart
│       │   │    Cart.php
│       │   └─── CartService.php
│       └───Checkout
│           └─── CheckoutService.php
│       
└───resource   
│   └───views
│       └───auth
│       │   │    login.blade.php
│       │   └─── register.blade.php
│       │    cart.blade.php
│       │    checkout.blade.php 
│       │    layout.blade.php 
│       │    placeorder.blade.php  
│       │    shop.blade.php 
│       └─── user.blade.php
└───route   
   └─── web.php
```

## Version
|版號| 發佈日期       | 內容          |
|----|------------|-------------|
| 1.0.0 | 2022/05/26 | 正式第一版       |

##TODO
- session資料放在redis中
- checkout時，先放入queue

