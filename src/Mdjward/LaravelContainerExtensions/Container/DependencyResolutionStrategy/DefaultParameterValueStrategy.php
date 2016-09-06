<?php

/**
 * DefaultParameterValueStrategy.php
 * Definition of class DefaultParameterValueStrategy
 * 
 * Created 21-Apr-2016 21:48:42
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use ReflectionParameter;

/**
 * DefaultParameterValueStrategy
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class DefaultParameterValueStrategy implements ResolutionStrategyInterface
{

    /**
     * 
     * @param Container $container
     * @param ReflectionParameter $parameterToMatch
     * @param array $givenPrimitives
     * @return mixed
     * @throws ResolutionFailedException
     */
    public function resolveParameter(
        Container $container,
        ReflectionParameter $parameterToMatch,
        array $givenPrimitives = [])
    {
        if ($parameterToMatch->isDefaultValueAvailable()) {
            return $parameterToMatch->getDefaultValue();
        }

        throw new ResolutionFailedException($parameterToMatch);
    }
    
}