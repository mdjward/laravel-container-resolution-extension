<?php
/**
 * AbstractNameAndPrimitiveTypeStrategyTestCase.php
 * Definition of class AbstractNameAndPrimitiveTypeStrategyTestCase
 *
 * Created 06-Sep-2016, 10:22:55 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

/**
 * AbstractNameAndPrimitiveTypeStrategyTestCase
 *
 * @author M.D.Ward <md.ward@quidco.com>
 */
abstract class AbstractNameAndPrimitiveTypeStrategyTestCase extends AbstractStrategyTestCase
{
    
    protected $parameterName = "PARAMETER NAME";

    protected function setUp()
    {
        parent::setUp();
        
        $this->container
            ->expects($this->once())
            ->method('bound')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(true))
        ;
    }
    
    protected function setUpParameterToMatch($getNameInvocations)
    {
        $this->parameterToMatch
            ->expects($this->exactly((int) $getNameInvocations))
            ->method('getName')
            ->will($this->returnValue($this->parameterName))
        ;
    }
    
}
