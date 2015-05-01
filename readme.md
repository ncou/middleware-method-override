# Method Override Middleware
Middleware handling and allowing to override the original request method. This is useful when the client aren't able to send other native request methods than GET and POST.

## Installation
This middleware is by default included in the [Phapi Framework](https://github.com/phapi/phapi) but if you need to install it it's available to install via [Packagist](https://packagist.org) and [Composer](https://getcomposer.org).

```shell
$ php composer.phar require phapi/middleware-method-override:1.*
```

## Configuration
It's possible to configure what override methods are allowed when the original request method is GET or POST.

Default settings:
* <code>'CONNECT', 'TRACE', 'GET', 'HEAD', 'OPTIONS'</code> are allowed to override GET requests.
* <code>'PATCH', 'PUT', 'DELETE', 'COPY', 'LOCK', 'UNLOCK'</code> are allowed to override POST requests.

```php
<?php

$pipeline->pipe(new \Phapi\Middleware\Override\Method(
  // Replace allowed methods to override GET
  ['HEAD', 'OPTIONS'],
  // Replace allowed methods to override POST
  ['PUT', 'DELETE']
);

```

## Phapi
This middleware is a Phapi package used by the [Phapi Framework](https://github.com/phapi/phapi). The middleware are also [PSR-7](https://github.com/php-fig/http-message) compliant and implements the [Phapi Middleware Contract](https://github.com/phapi/contract).

## License
Method Override Middleware is licensed under the MIT License - see the [license.md](https://github.com/phapi/middleware-method-override/blob/master/license.md) file for details

## Contribute
Contribution, bug fixes etc are [always welcome](https://github.com/phapi/middleware-method-override/issues/new).
