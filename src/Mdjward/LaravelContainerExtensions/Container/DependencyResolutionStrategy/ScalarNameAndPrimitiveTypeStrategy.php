<?php
/**
 * ScalarNameAndPrimitiveTypeStrategy.php
 * Definition of class ScalarNameAndPrimitiveTypeStrategy
 *
 * Created 06-Sep-2016, 10:07:50 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use ReflectionParameter;

/**
 * ScalarNameAndPrimitiveTypeStrategy
 *
 * @author M.D.Ward <md.ward@quidco.com>
 */
class ScalarNameAndPrimitiveTypeStrategy extends AbstractNameAndPrimitiveTypeStrategy
{

    /**
     * 
     * @param ReflectionParameter $parameter
     * @return boolean
     */
    protected function acceptParameter(ReflectionParameter $parameter)
    {
        return ($parameter->getClass() === null);
    }
    
    /**
     * 
     * @param mixed $value
     * @return boolean
     */
    protected function acceptValue($value)
    {
        return is_scalar($value);
    }

}
