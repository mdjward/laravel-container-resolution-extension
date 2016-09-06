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
        if (($instance = $this->doResolveParameter($parameterToMatch->getName(), $container, $parameterToMatch)) !== null) {
            return $instance;
        }
        
        throw new ResolutionFailedException($parameterToMatch);
    }
    
    /**
     * 
     * @param string $parameterName
     * @param Container $container
     * @param ReflectionParameter $parameterToMatch
     * @return object|null
     */
    protected function doResolveParameter(
        $parameterName,
        Container $container,
        ReflectionParameter $parameterToMatch
    ) {
        if (($parameterType = $parameterToMatch->getClass()) === null) {
            return null;
        }
        
        if (!$container->bound($parameterName)) {
            return null;
        }
        
        if (
            !$parameterType->isInstance(
                ($instance = $container->make($parameterName))
            )
        ) {
            return null;
        }
        
        return $instance;
    }
    
}
