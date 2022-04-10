PHP-OPENAPI
===========

This library (mostly) implements the OpenAPI 3.0 specification for PHP. This library has been written from scratch and designed around the native attribute system introduced with PHP 8.1, hence older versions of PHP are not supported.

As of now the documentation is very scarce. This is still work-in-progress and won't be fully documented until a stable release is on the cards.

## Requirements

- PHP 8.1+

## Features

The library provides a set of OpenAPI elements used to construct the actual documentation tree.

Additionally provided is a basic set of tools for generating documentation from annotated code by crawling through a list of defined directories. However, no configuration nor "factories" for setting up the documentation system is provided. For an out-of-the-box experience, check the related [Symfony module](/sjuvonen/php-openapi-bundle).

## Design

Very few convenience hacks are provided. The structure of required PHP attributes follows closely the original structure of the OpenAPI documentation. All class properties and methods are fully type-hinted, which makes it easier to understand how to compile a documentation node.
