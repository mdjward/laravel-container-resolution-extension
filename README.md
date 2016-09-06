# Laravel container resolution extension #

[![Build Status](https://scrutinizer-ci.com/g/mdjward/laravel-container-resolution-extension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mdjward/laravel-container-resolution-extension/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mdjward/laravel-container-resolution-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mdjward/laravel-container-resolution-extension/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mdjward/laravel-container-resolution-extension/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mdjward/laravel-container-resolution-extension/?branch=master)

An extension to the Laravel container to support multiple mechanisms of dependency resolution, implemented as strategies.

## Example usage ##

Replace the directive instantiating your container (in the [standard Laravel distribution](http://github.com/laravel/laravel) this will be in [`boostrap/app.php`](https://github.com/laravel/laravel/blob/master/bootstrap/app.php) - lines 14 - 16) with the following:

```php
$app = new Mdjward\LaravelContainerExtensions\Application\Application(
    realpath(__DIR__.'/../'),
    [
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\GivenParametersStrategy(),
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\NameAndTypeStrategy(),
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ArrayNameAndPrimitiveTypeStrategy(),
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\CallableNameAndPrimitiveTypeStrategy(),
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ScalarNameAndPrimitiveTypeStrategy(),
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\TypeOnlyStrategy(),
        new Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\DefaultParameterValueStrategy(),
    ]
);
```

## Strategies ##

This solution overrides the existing `Application::getDependencies` method - which defers to three de-facto "strategies" - and instead loops through the strategies injected by way of the constructor.

Consequently, the the base three strategies have been rewritten into this system.  A further five strategies have been defined to enhance the Laravel autoloader.

### Ported from Laravel ###

1. **GivenParametersStrategy** attempts to resolve parameters using the second argument passed to `getDependencies`.
2. **DefaultParameterValueStrategy** attempts to resolve parameter values using the "default" parameter value in the constructor (if any is given).
3. **TypeOnlyStrategy** attempts to resolve based on type (assuming that a concretion is mapped, or an abstraction to a concretion).  This is the most widely recognised Laravel mechanism for object resolution.

### New strategies ###

1. **NameAndTypeStrategy** - This attempts to match a service defined in the container based on parameter name and cross-referenced by hitned type.
2. **ArrayNameAndPrimitiveTypeStrategy** - Similar to above, but for parameters using the `array` type hint as it exists in PHP 5.6.
3. **CallableNameAndPrimitiveTypeStrategy** - Similar to above, but for parameters using the `callable` or `Closure` type hints as they exists in PHP 5.6.
4. **ScalarNameAndPrimitiveTypeStrategy** - This attempts to match a scalar value (no hint).

### Implementing your own ###

Create a class implementing (directly or otherwise) [`ResolutionStrategyInterface`](https://github.com/mdjward/laravel-container-resolution-extension/blob/master/src/Mdjward/LaravelContainerExtensions/Container/DependencyResolutionStrategy/ResolutionStrategyInterface.php) and inject an object of your implementation class into the `Application` constructor as shown above.

