<?php
/**
 * CallableNameAndPrimitiveTypeStrategy.php
 * Definition of class CallableNameAndPrimitiveTypeStrategy
 *
 * Created 06-Sep-2016, 9:57:28 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use ReflectionParameter;

/**
 * CallableNameAndPrimitiveTypeStrategy
 *
 * @author M.D.Ward <md.ward@quidco.com>
 */
class CallableNameAndPrimitiveTypeStrategy extends AbstractNameAndPrimitiveTypeStrategy
{
    
    /**
     * 
     * @param ReflectionParameter $parameter
     * @return boolean
     */
    protected function acceptParameter(ReflectionParameter $parameter)
    {
        return $parameter->isCallable();
    }
    
    /**
     * 
     * @param mixed $value
     * @return boolean
     */
    protected function acceptValue($value)
    {
        return is_callable($value);
    }
    
}
