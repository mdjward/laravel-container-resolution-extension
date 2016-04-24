<?php

/**
 * NameAndTypeStrategyTest.php
 * Definition of class NameAndTypeStrategyTest
 * 
 * Created 24-Apr-2016 15:21:35
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use ReflectionClass;

/**
 * NameAndTypeStrategyTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */
class NameAndTypeStrategyTest extends AbstractStrategyTestCase
{
    
    /**
     *
     * @var NameAndTypeStrategy
     */
    private $strategy;
    
    private $parameterName;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->strategy = new NameAndTypeStrategy();
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will(
                $this->returnValue(($this->parameterName = 'PARAMETER NAME'))
            )
        ;
    }
    
    public function testResolveParameterReturnsCorrectlyTypedParameter()
    {
        $parameterType = $this
            ->getMockBuilder(ReflectionClass::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue($parameterType))
        ;

        $this->container
            ->expects($this->once())
            ->method('bound')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(true))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(($parameterValue = new \StdClass())))
        ;

        $parameterType
            ->expects($this->once())
            ->method('isInstance')
            ->with($this->identicalTo($parameterValue))
            ->will($this->returnValue(true))
        ;
        
        $this->assertSame(
            $parameterValue,
            $this->strategy->resolveParameter($this->container, $this->parameterToMatch)
        );
    }
    
}
