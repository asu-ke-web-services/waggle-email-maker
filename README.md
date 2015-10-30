# Waggle Email Maker

[![Build Status](https://travis-ci.org/gios-asu/waggle-email-maker.svg?branch=develop)](https://travis-ci.org/gios-asu/waggle-email-maker?branch=develop)
[![Coverage Status](https://coveralls.io/repos/gios-asu/waggle-email-maker/badge.svg?branch=develop&service=github)](https://coveralls.io/github/gios-asu/waggle-email-maker?branch=develop)
[![Code Climate](https://codeclimate.com/github/gios-asu/waggle-email-maker/badges/gpa.svg)](https://codeclimate.com/github/gios-asu/waggle-email-maker)

PHP email utilities for creating email safe HTML

## Documentation

### Installation

TODO

### Email Handlebars Factory

Example usage:

```
use Waggle\Factories\EmailHandlebarsFactory;

$factory = new EmailHandlebarsFactory();
$factory->set_data( array( 'title' => 'My Awesome Email' ) );
$factory->set_css( 'h1 { font-size: 20px }' );
$factory->set_handlebars( '<h2>{{title}}</h2>' );
echo $factory->build();
```