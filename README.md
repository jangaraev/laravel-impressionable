# laravel-impressionable

[![Total Downloads](http://poser.pugx.org/jangaraev/laravel-impressionable/downloads)](https://packagist.org/packages/jangaraev/laravel-impressionable)
[![License](http://poser.pugx.org/jangaraev/laravel-impressionable/license)](https://packagist.org/packages/jangaraev/laravel-impressionable)

A useful package to automate impressions (views) counting.

## Table of Contents

- <a href="#installation">Installation</a>
- <a href="#usage">Usage</a>
- <a href="#morph-map">Morph map</a>
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

## Morph Map

It's possible to add a _morph map_ to introduce a shorter and more user-friendly
model names that will be written to DB instead of the model's fully-qualified name.

```
+------------+---------------------+-------------------+------------+
| date       | impressionable_type | impressionable_id | ip         |
+------------+---------------------+-------------------+------------+
| 2022-05-17 | foo                 |                65 | 2130706433 |
| 2022-05-17 | \App\Models\Foo     |                65 | 2130706433 |
+------------+---------------------+-------------------+------------+
```

The first row is written using morph map and the second one is not,
both references the same model.

*Important!* You can't combine both approaches. If you have morph relationships already written
and referenced in the DB, they become invalid when you introduce them to the morph map.

_Say, you have a model `Cat` which is already referenced in the DB. If you re-map
it in morph map to anything different from model's FQN then you'll get your references
dead. A solution here is to map models from the very beginning or create a migration
which will re-map existing references to the new writing._

Example of a typical morph map which is registered via service provider:

```php
namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphMapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Relation::morphMap([
            'cat' => \App\Models\Cat::class,
            'dog' => \App\Models\Dog::class,
            // ...
            'foo' => \App\Models\Foo::class,
            'bar' => \App\Models\Bar::class,
        ]);
    }
}

```

## License

Package is an open-sourced laravel package licensed under the MIT license.