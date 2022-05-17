# laravel-impressionable

[![Total Downloads](http://poser.pugx.org/jangaraev/laravel-impressionable/downloads)](https://packagist.org/packages/jangaraev/laravel-impressionable)
[![License](http://poser.pugx.org/jangaraev/laravel-impressionable/license)](https://packagist.org/packages/jangaraev/laravel-impressionable)

A useful package to automate impressions (views) counting.

## Table of Contents

- <a href="#installation">Installation</a>
- <a href="#usage">Usage</a>
- <a href="#license">License</a>

## Installation

```bash
$ composer require jangaraev/laravel-impressionable
```

You also have to publish the migration file which creates a DB table to store
impressions data. Run the newly published migration.

```bash
$ php artisan vendor:publish --provider="Jangaraev\LaravelImpressionable\ImpressionableServiceProvider" --tag="migrations"
$ php artisan migrate
```

## Usage

Align appropriate models by declaring the interface and add the helper trait.

```php
namespace App\Models;  
 
use Illuminate\Database\Eloquent\Model;
use Jangaraev\LaravelImpressionable\Contracts\Impressionable;
use Jangaraev\LaravelImpressionable\Traits\CountsImpressions;
 
class MyModel extends Model implements Impressionable
{
    use CountsImpressions;
}
```

Once done, it's now possible to call the `incrementImpressions()` method on that model.

Typically in the `show()` method of a controller:

```php
public function show(string $slug)
{
    $modelInstance = $modelRepository::getBySlug($slug);
 
    // fetching related models, doing required checks, setting up meta tags, etc  
 
    $modelInstance->incrementImpressions();
 
    return view('show', compact('modelInstance'));
}
```

Printing impressions is as easy as

```php
// prints value from DB
echo $model->impressions;
```

## License

Package is an open-sourced laravel package licensed under the MIT license.