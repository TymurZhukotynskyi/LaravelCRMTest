Для встановлення потрібно:

PHP версії більше 8.2

Postgres останніх версій.

На проекті використовується Laravel 12

Встановлення досить стандартне:

````
cp .env.example .env
````

````
php artisan key:generate
````

````
composer install
````

````
php artisan migrate
````

````
php artisan serve
````

Сайт знаходиться за адресою:
https://laravel-c-r-m-test-f62335e77055.herokuapp.com/

Дві основні вкладки:

Клієнти: https://laravel-c-r-m-test-f62335e77055.herokuapp.com/customers

Ордери: https://laravel-c-r-m-test-f62335e77055.herokuapp.com/orders 
