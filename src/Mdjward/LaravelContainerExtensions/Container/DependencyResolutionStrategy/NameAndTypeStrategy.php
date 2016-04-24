<?php

/**
 * NameAndTypeStrategy.php
 * Definition of class NameAndTypeStrategy
 * 
 * Created 21-Apr-2016 21:38:25
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use ReflectionParameter;

/**
 * NameAndTypeStrategy
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class NameAndTypeStrategy implements ResolutionStrategyInterface
{
    
    public function resolveParameter(
        Container $container,
        ReflectionParameter $parameterToMatch,
        array $givenParameters = [],
        array $givenPrimitives = []
    ) {
        $parameterName = $parameterToMatch->getName();
        
        if (
            ($parameterType = $parameterToMatch->getClass()) === null
            || !$container->bound($parameterName)
            || !$parameterType->isInstance(
                ($instance = $container->make($parameterName))
            )
        ) {
            throw new ResolutionFailedException($parameterToMatch);
        }
        
        return $instance;
    }
    
}
