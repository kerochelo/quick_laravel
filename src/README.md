# readme

## create laravel setting and command
- change timezone to japan

```php:config/app.php
'timezone' => 'Asia/Tokyo',
'locale' => 'ja',
```

- create controller

```sh
php artisan make:controller HogeController
```

- create model & migration

```sh
php artisan make:model Hoge -m
```

- create seed（=>database/seeders/DatabaseSeeder.php）

```sh
php artisan make:seeder HogeSeeder
```

- run add seed data

```sh
php artisan db:seed
```
