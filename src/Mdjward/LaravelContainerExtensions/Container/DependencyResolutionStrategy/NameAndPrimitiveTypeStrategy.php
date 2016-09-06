<?php

/**
 * NameAndPrimitiveTypeStrategy.php
 * Definition of class NameAndPrimitiveTypeStrategy
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
 * NameAndPrimitiveTypeStrategy
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class NameAndPrimitiveTypeStrategy
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
        if ($parameterToMatch->isArray()) {
            return $this->validateAndResolve(
                $container,
                $parameterToMatch,
                'is_array'
            );
        }

        if ($parameterToMatch->isCallable()) {
            return $this->validateAndResolve(
                $container,
                $parameterToMatch,
                'is_callable'
            );
        }
        
        if ($parameterToMatch->getClass() === null) {
            return $this->validateAndResolve(
                $container,
                $parameterToMatch,
                'is_scalar'
            );
        }

        throw new ResolutionFailedException($parameterToMatch);
    }

    /**
     * 
     * @param Container $container
     * @param ReflectionParameter $parameter
     * @param callable|null $validationFunction
     * @return mixed
     * @throws ResolutionFailedException
     */
    protected function validateAndResolve(
        Container $container,
        ReflectionParameter $parameter,
        callable $validationFunction = null
    ) {
        $parameterName = $parameter->getName();
        
        if (
            $container->bound($parameterName)
            && ($containedValue = $container->make($parameterName)) !== null
            && (
                $validationFunction === null
                || call_user_func($validationFunction, $containedValue) === true
            )
        ) {
            return $containedValue;
        }

        throw new ResolutionFailedException($parameter);
    }

}