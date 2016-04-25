<?php

/**
 * Application.php
 * Definition of class Application
 * 
 * Created 21-Apr-2016 21:31:40
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Application;

use Illuminate\Foundation\Application as LaravelApplication;
use Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException;
use Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionStrategyInterface;
use ReflectionParameter;



/**
 * Application
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class Application extends LaravelApplication
{

    /**
     *
     * @var array
     */
    protected $dependencyResolutionStrategies;

    
    
    /**
     * 
     * @param string|null $basePath
     * @param array $dependencyResolutionStrategies
     */
    public function __construct(
        $basePath = null,
        array $dependencyResolutionStrategies = []
    ) {
        parent::__construct($basePath);

        $this->setDependencyResolutionStrategies($dependencyResolutionStrategies);
    }

    /**
     * 
     * @param array $dependencyResolutionStrategies
     * @return Application
     */
    public function setDependencyResolutionStrategies(
        array $dependencyResolutionStrategies
    ) {
        $this->dependencyResolutionStrategies = [];
        
        foreach ($dependencyResolutionStrategies as $strategy) {
            $this->addDependencyResolutionStrategy($strategy);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param ResolutionStrategyInterface $strategy
     */
    protected function addDependencyResolutionStrategy(
        ResolutionStrategyInterface $strategy
    ) {
        $this->dependencyResolutionStrategies[] = $strategy;
    }

    /**
     * 
     * @param array $parameters
     * @param array $primitives
     * @return array
     */
    protected function getDependencies(array $parameters, array $primitives = array())
    {
        $dependencies = [];
        
        foreach ($parameters as $parameter) {
            try {
                $dependencies[] = $this->resolveDependency($parameter, $primitives);
            } catch (ResolutionFailedException $ex) {
                $dependencies[] = null;
            }
        }
        
        return $dependencies;
    }

    /**
     * 
     * @param ReflectionParameter $parameter
     * @param array $passedPrimitives
     * @return mixed
     * @throws ResolutionFailedException
     */
    protected function resolveDependency(
        ReflectionParameter $parameter,
        array $passedPrimitives
    ) {
        foreach ($this->dependencyResolutionStrategies as $strategy) {
            if (
                ($resolvedInstance = (
                    $strategy->resolveParameter(
                        $this,
                        $parameter,
                        $passedPrimitives
                    )
                )) !== null
            ) {
                return $resolvedInstance;
            }
        }

        throw new ResolutionFailedException($parameter);
    }
    
}
