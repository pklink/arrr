[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=pierre111&url=https://github.com/pklink/file-router.git&title=FileRouter&language=&tags=github&category=software)

[![Build Status](https://travis-ci.org/pklink/file-router.png?branch=master)](https://travis-ci.org/pklink/file-router)


# FileRouter

A library for mapping files in a directory to routes like `hello/world`


## Installation

Install FileRouter with Composer

Create or update your composer.json

```json
{
    "require": {
        "pklink/file-router": "0.*"
    }
}
```

And run Composer

```bash
php composer.phar install
```

Finally include Composers autoloader

```bash
include __DIR__ . '/vendor/autoload.php';
```

## Usage

### Router/Load for including PHP files

We have the following file structure:
	
```bash
.
├── example.php
└── includes
	├── hello
	│   └── world.php
    └── hello.php
```

And here is our `example.php`

```php
// the source path for including files
$sourcePath = new SplFileInfo(__DIR__ . '/includes');

// create router
$router = new \FileRouter\Router\Load($sourcePath);
```

Now you can load/include files in the `includes`-directory

```php
$router->handleRoute('hello'); // include includes/hello.php
$router->handleRoute('hello/world'); // include includes/hello/world.php
```

Or like this:

```php
$router->handleRoute($_GET['r']);
```

*You can find a complete example in example.php*


### Router/OutputTxt for printing txt-files

We have the following file structure:
	
```bash
.
├── example.php
└── docs
	├── hello
	│   └── world.txt
    └── hello.txt
```

And here is our `example.php`

```php
// the source path for including files
$sourcePath = new SplFileInfo(__DIR__ . '/docs');

// create router
$router = new \FileRouter\Router\OutputTxt($sourcePath);
```

Now you can print/output files in the `docs`-directory

```php
$router->handleRoute('hello'); // print includes/hello.txt
$router->handleRoute('hello/world'); // print includes/hello/world.txt
```

*You can find a complete example in example.php*


## Advanced Usage

### Write your own Router

It is no problem to write and add your own router. Implement the interface `\FileRouter\Router` or use the abtract implementation of `\FileRouter\Router\AbstractImpl`, so you only need to implement `Router::handleRoute()`

```php
class CustomRouter extends \FileRouter\Router\AbstractImpl
{

	public function handleRoute($router)
	{
		/* @var \SplFileInfo $routingFile */
		$routingFile = $this->getFileByRoute($route);
		
		// do something
	}

}	
```

## Run Tests

You can use [PHPUnit] from the vendor-folder.

```bash
php composer.phar install --dev
php vendor/bin/phpunit tests/
```

or with code-coverage-report

```bash
php composer.phar install --dev
php vendor/bin/phpunit --coverage-html output tests/
```

## Create API Documentation

You find the documentation in `<package-root>/docs`. If you like to create your own documentation you can use [ApiGen].

```bash
php composer.phar install --dev
php vendor/bin/apigen.php -s src/ -d docs/
```


## License

This package is licensed under the MIT License. See the LICENSE file for details.

## Credits
* [Composer]
* [PHPUnit]
* [ApiGen]


[ApiGen]: https://github.com/apigen/apigen
[PHPUnit]: http://www.phpunit.de/
[Composer]: http://getcomposer.org/