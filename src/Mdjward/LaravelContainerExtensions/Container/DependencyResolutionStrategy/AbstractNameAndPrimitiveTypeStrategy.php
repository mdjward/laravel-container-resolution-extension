<?php

/**
 * AbstractNameAndPrimitiveTypeStrategy.php
 * Definition of class AbstractNameAndPrimitiveTypeStrategy
 * 
 * Created 21-Apr-2016 21:50:33
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use ReflectionParameter;

/**
 * AbstractNameAndPrimitiveTypeStrategy
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
abstract class AbstractNameAndPrimitiveTypeStrategy implements ResolutionStrategyInterface
{

    /**
     * 
     * @param Container $container
     * @param ReflectionParameter $parameterToMatch
     * @param array $givenPrimitives
     * @return mixed
     * @throws ResolutionFailedException
     */
    final public function resolveParameter(
        Container $container,
        ReflectionParameter $parameterToMatch,
        array $givenPrimitives = array()
    ) {
        if (($instance = $this->extractContainedValue($container, $parameterToMatch)) !== null) {
            return $instance;
        }

        throw new ResolutionFailedException($parameterToMatch);
    }
    
    /**
     * 
     * @param Container $container
     * @param ReflectionParameter $parameterToMatch
     * @return mixed|null
     */
    private function extractContainedValue(
        Container $container,
        ReflectionParameter $parameterToMatch
    ) {
        return (
            $container->bound(($parameterName = $parameterToMatch->getName()))
            && $this->acceptParameter($parameterToMatch)
            && $this->acceptValue(($value = $container->make($parameterName)))
            ? $value
            : null
        );
    }
    
    /**
     * 
     * @param ReflectionParameter $parameter
     * @return boolean
     */
    abstract protected function acceptParameter(
        ReflectionParameter $parameter
    );
    
    /**
     * 
     * @param mixed $value
     * @return boolean
     */
    abstract protected function acceptValue($value);

}