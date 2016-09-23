# An improved Hasher for Laravel 5
**CAUTION: This package is rather new and has not yet been well tested.**

This is a simple and easy to extend Library that replaces the default Laravel 5 Hasher.

It wraps bcrypt-SHA512 (other algorithm combinations are supported) and uses Laravel's encryption capabilities to generate an encrypted version of the Hash.

Inspired by:
- https://blogs.dropbox.com/tech/2016/09/how-dropbox-securely-stores-your-passwords/
- https://github.com/paragonie/password_lock

**This package requires you to overwrite the stock Laravel Hash implementation.**

## Installation
Require the package using composer:
```php
composer require clumsypixel/laravel-hasher
```

Replace Laravel's hasher implementation (Illuminate\Hashing\HashServiceProvider::class) in your config/app.php with the following:
```php
'providers' => [
    ClumsyPixel\Hasher\HasherServiceProvider::class
]
```

Laravel Hasher needs to adjust your password column to support the longer, encrypted password string. You can publish the migration using the following command.
```shell
$ php artisan vendor:publish --tag=migrations
```


## Optional: Configuration
To get started with custom configuration, publish the package config:
```shell
$ php artisan vendor:publish --tag=config
```
The following options are available:
##### Intermediate Hasher
*Default: Laravel Stock bcrypt hasher*

This option sets the intermediate hasher to be used.
You can specify any hasher that implements Laravel's HasherContract (Illuminate\Contracts\Hashing\Hasher).

##### Algorithm
*Default: SHA512*

This option sets the algorithm to be used to encrypt the plaintext value before the intermediate hasher is applied and supports anything your PHP version supports.
Refer to http://php.net/manual/en/function.hash-algos.php to find out what algorithms are supported.

##### Options
This option sets additional options that your intermediate hasher might require to function e.g. Bcrypt's adjustable cost factor.

## License
This package is licensed under The MIT License.