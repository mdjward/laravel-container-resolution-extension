<?php
/**
 * ArrayNameAndPrimitiveTypeStrategy.php
 * Definition of class ArrayNameAndPrimitiveTypeStrategy
 *
 * Created 06-Sep-2016, 10:02:36 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use ReflectionParameter;

/**
 * ArrayNameAndPrimitiveTypeStrategy
 *
 * @author M.D.Ward <md.ward@quidco.com>
 */
class ArrayNameAndPrimitiveTypeStrategy extends AbstractNameAndPrimitiveTypeStrategy
{

    /**
     * 
     * @param ReflectionParameter $parameter
     * @return boolean
     */
    protected function acceptParameter(ReflectionParameter $parameter)
    {
        return $parameter->isArray();
    }
    
    /**
     * 
     * @param mixed $parameterValue
     * @return boolean
     */
    protected function acceptValue($parameterValue)
    {
        return is_array($parameterValue);
    }

}
