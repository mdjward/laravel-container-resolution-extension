<?php

/**
 * GivenParametersStrategy.php
 * Definition of class GivenParametersStrategy
 * 
 * Created 21-Apr-2016 21:55:20
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use ReflectionParameter;

/**
 * GivenParametersStrategy
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class GivenParametersStrategy implements ResolutionStrategyInterface
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
        array $givenPrimitives = []
    ) {
        $parameterName = $parameterToMatch->getName();
        
        if (isset($givenPrimitives[$parameterName])) {
            return $givenPrimitives[$parameterName];
        }
        
        throw new ResolutionFailedException($parameterToMatch);
    }
    
}
