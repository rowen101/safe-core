#### Configuration (Optional)

```bash
composer require yajra/laravel-datatables-oracle:"^10.0"
```

#### Service Provider & Facade (Optional on Laravel 5.5+)

Register provider and facade on your `config/app.php` file.
```php
'providers' => [
    ...,
    Yajra\DataTables\DataTablesServiceProvider::class,
]

'aliases' => [
    ...,
    'DataTables' => Yajra\DataTables\Facades\DataTables::class,
]
```

```bash
php artisan vendor:publish --provider="Yajra\DataTables\DataTablesServiceProvider"
```

And that's it! Start building out some awesome DataTables!


## Breadcrumbs
```bash
composer require diglactic/laravel-breadcrumbs
```
## Intervention image
```bash
composer require intervention/image
```

## Debugging Mode

To enable debugging mode, just set `APP_DEBUG=true` and the package will include the queries and inputs used when processing the table.

**IMPORTANT:** Please make sure that APP_DEBUG is set to false when your app is on production.

## PHP ARTISAN SERVE BUG

Please avoid using `php artisan serve` when developing with the package.
There are known bugs when using this where Laravel randomly returns a redirect and 401 (Unauthorized) if the route requires authentication and a 404 NotFoundHttpException on valid routes.

It is advised to use [Homestead](https://laravel.com/docs/5.4/homestead) or [Valet](https://laravel.com/docs/5.4/valet) when working with the package.

## Contributing

Please see [CONTRIBUTING](https://github.com/yajra/laravel-datatables/blob/master/.github/CONTRIBUTING.md) for details.


## Installation

- Clone the repository
- Copy .env.example to .env
- Set the DB_ environment variables in .env file
- Create a database with the name specified in DB_DATABASE
- ```composer install```
- ```npm install```
- ```php artisan key:generate```
- Migrate and seed the database with ```php artisan migrate:fresh --seed```
- Run the application:
- ```php artisan serve```
- ```npm run dev```
- You can now log in with user "john@example.com", password "password"


## Authors

- [@clovon](https://www.github.com/clovon)


## Feedback

If you have any feedback, please reach out to me at channel.clovon@gmail.com


## License

[MIT](https://choosealicense.com/licenses/mit/)
