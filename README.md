# Waggle Email Maker

[![Build Status](https://travis-ci.org/gios-asu/waggle-email-maker.svg?branch=develop)](https://travis-ci.org/gios-asu/waggle-email-maker?branch=develop)
[![Coverage Status](https://coveralls.io/repos/gios-asu/waggle-email-maker/badge.svg?branch=develop&service=github)](https://coveralls.io/github/gios-asu/waggle-email-maker?branch=develop)
[![Code Climate](https://codeclimate.com/github/gios-asu/waggle-email-maker/badges/gpa.svg)](https://codeclimate.com/github/gios-asu/waggle-email-maker)

PHP email utilities for creating email safe HTML

## Documentation

### Installation

```
composer require gios-asu/waggle-email-maker
```

### Email Handlebars Factory

Basic usage:

```php
use Waggle\Factories\EmailHandlebarsFactory;

$factory = new EmailHandlebarsFactory();
$factory->set_data( array( 'title' => 'My Awesome Email' ) );
$factory->set_css( 'h1 { font-size: 20px }' );
$factory->set_handlebars( '<h2>{{title}}</h2>' );
echo $factory->build();
```

The constructor for `EmailHandlebarsFactory` allows for dependency injection,
which you can use to pass in your own `scss`, `Handlebars`, or `Emogrifier`
objects:

```php
use Waggle\Factories\EmailHandlebarsFactory;
use Handlebars\Handlebars;

$handlebars = new Handlebars(
    array(
      'loader' => new \Handlebars\Loader\FilesystemLoader( '/var/www/html/email-templates' ),
    )
);

$factory = new EmailHandlebarsFactory( null, $handlebars );
$factory->set_data( array( 'title' => 'My Awesome Email' ) );
$factory->set_css( 'h1 { font-size: 20px }' );
$factory->set_handlebars( 'my-email.handlebars' );
echo $factory->build();
```