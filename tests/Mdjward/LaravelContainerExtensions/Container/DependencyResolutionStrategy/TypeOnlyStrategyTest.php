<?php

/**
 * TypeOnlyStrategyTest.php
 * Definition of class TypeOnlyStrategyTest
 * 
 * Created 24-Apr-2016 16:30:01
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;

use ReflectionClass;

/**
 * TypeOnlyStrategyTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>#
 * @coversDefaultClass \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\TypeOnlyStrategy
 */
class TypeOnlyStrategyTest extends AbstractStrategyTestCase
{
    
    /**
     *
     * @var TypeOnlyStrategy
     */
    private $strategy;
    
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->strategy = new TypeOnlyStrategy();
    }
    
    /**
     * 
     * @test
     * @covers ::resolveParameter
     */
    public function testResolveParameterResolvesIfTypeIsAvailable()
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
        
        $parameterType
            ->expects($this->once())
            ->method('getName')
            ->will(
                $this->returnValue(
                    ($parameterTypeName = "Arbitrary\\Class\\Name")
                )
            )
        ;
        
        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($parameterTypeName))
            ->will($this->returnValue(($expectedValue = 'expected value')))
        ;
        
        $this->assertSame(
            $expectedValue,
            $this->strategy->resolveParameter(
                $this->container,
                $this->parameterToMatch
            )
        );
    }
    
    /**
     * 
     * @test
     * @covers ::resolveParameter
     * @covers \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException::__construct
     */
    public function testResolveParameterThrowsExceptionIfNoParameterType()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue(null))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(($parameterName = 'PARAMETER NAME')))
        ;
        
        $this->setExpectedException(
            ResolutionFailedException::class,
            "Failed to resolve parameter " . $parameterName
        );
        
        $this->strategy->resolveParameter(
            $this->container,
            $this->parameterToMatch
        );
    }
    
}
