## Black Tea Software. Php/Laravel experience test

## Install
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

#### Unit Test
##### Create database/test.sqlite file manually. See .env.testing for more information
```
php artisan test
```
