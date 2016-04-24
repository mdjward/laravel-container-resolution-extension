<?php

/**
 * TypeOnlyStrategy.php
 * Definition of class TypeOnlyStrategy
 * 
 * Created 21-Apr-2016 21:35:39
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use ReflectionParameter;

/**
 * TypeOnlyStrategy
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class TypeOnlyStrategy implements ResolutionStrategyInterface
{

    /**
     * 
     * @param Container $container
     * @param ReflectionParameter $parameterToMatch
     * @param array $givenParameters
     * @param array $givenPrimitives
     * @return object
     * @throws ResolutionFailedException
     */
    public function resolveParameter(
        Container $container,
        ReflectionParameter $parameterToMatch,
        array $givenParameters = [],
        array $givenPrimitives = []
    ) {
        if (($parameterType = $parameterToMatch->getClass()) === null) {
            throw new ResolutionFailedException($parameterToMatch);
        }

        return $container->make($parameterType->getName());
    }
    
}
