<?php

/**
 * ResolutionFailedException.php
 * Definition of class ResolutionFailedException
 * 
 * Created 21-Apr-2016 21:39:45
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Exception;
use ReflectionParameter;

/**
 * ResolutionFailedException
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class ResolutionFailedException extends Exception
{
    
    /**
     *
     * @var ReflectionParameter
     */
    private $parameter;
    
    
    
    /**
     * 
     * @param ReflectionParameter $parameter
     */
    public function __construct(ReflectionParameter $parameter)
    {
        parent::__construct(
            "Failed to resolve parameter " . $parameter->getName()
        );

        $this->parameter = $parameter;
    }
    
    /**
     * 
     * @return ReflectionParameter
     */
    public function getParameter()
    {
        return $this->parameter;
    }
    
}