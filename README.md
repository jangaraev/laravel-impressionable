# laravel-impressionable

## Install

```bash
$ composer require jangaraev/laravel-impressionable
```

In Laravel 5.5 the service provider will automatically get registered. In older
versions of the framework just add the service provider in config/app.php file:

```php
'providers' => [
    // ...
    Jangaraev\LaravelImpressionable\ImpressionableServiceProvider::class,
];
```

Then you have to publish the migration file which will create a DB table to store
impressions data. Run the newly published migration.

```bash
$ php artisan vendor:publish --provider="Jangaraev\LaravelImpressionable\ImpressionableServiceProvider" --tag="migrations"
$ php artisan migrate
```

Optionally publish a configuration file.

```bash
$ php artisan vendor:publish --provider="Jangaraev\LaravelImpressionable\ImpressionableServiceProvider" --tag="config"
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