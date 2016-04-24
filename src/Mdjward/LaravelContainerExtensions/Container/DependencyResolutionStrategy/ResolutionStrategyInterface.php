<?php

/**
 * ResolutionStrategyInterface.php
 * Definition of interface ResolutionStrategyInterface
 * 
 * Created 21-Apr-2016 21:32:29
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use ReflectionParameter;



/**
 * ResolutionStrategyInterface
 * 
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
interface ResolutionStrategyInterface
{
    
    /**
     * 
     * @param Container $container
     * @param ReflectionParameter $parameterToMatch
     * @param array $givenPrimitives
     */
    public function resolveParameter(
        Container $container,
        ReflectionParameter $parameterToMatch,
        array $givenPrimitives = []
    );
    
}
