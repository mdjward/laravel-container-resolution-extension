<?php

/**
 * AbstractStrategyTestCase.php
 * Definition of class AbstractStrategyTestCase
 * 
 * Created 23-Apr-2016 08:33:08
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use Illuminate\Contracts\Container\Container;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionParameter;

/**
 * AbstractStrategyTestCase
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
abstract class AbstractStrategyTestCase extends TestCase
{
    
    /**
     *
     * @var MockObjectMockObject 
     */
    protected $container;
    
    /**
     *
     * @var MockObject
     */
    protected $parameterToMatch;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        $this->container = $this->getMockForAbstractClass(Container::class);

        $this->parameterToMatch = $this
            ->getMockBuilder(ReflectionParameter::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
    
}
