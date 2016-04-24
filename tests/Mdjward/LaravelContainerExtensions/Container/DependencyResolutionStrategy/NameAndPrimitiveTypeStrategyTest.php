<?php

/**
 * NameAndPrimitiveTypeStrategyTest.php
 * Definition of class NameAndPrimitiveTypeStrategyTest
 * 
 * Created 24-Apr-2016 14:26:56
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * NameAndPrimitiveTypeStrategyTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * @coversDefaultClass \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\NameAndPrimitiveTypeStrategy
 */
class NameAndPrimitiveTypeStrategyTest extends AbstractStrategyTestCase
{
    
    /**
     *
     * @var NameAndPrimitiveTypeStrategy
     */
    private $strategy;
    
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->strategy = new NameAndPrimitiveTypeStrategy();
    }
    
    /**
     * @test
     * @covers ::resolveParameter
     * @covers ::validateAndResolve
     */
    public function testResolveParameterResolvesArrayHintedValue()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(true))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(($parameterName = 'VALID ARRAY PARAMETER')))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('bound')
            ->with(
                $this->identicalTo($parameterName)
            )
            ->will($this->returnValue(true))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('make')
            ->with(
                $this->identicalTo($parameterName)
            )
            ->will($this->returnValue(($containedValue = [1, 2, 3, 4, 5])))
        ;
        
        $this->assertSame(
            $containedValue,
            $this->strategy->resolveParameter(
                $this->container,
                $this->parameterToMatch
            )
        );
    }
    
    /**
     * @test
     * @covers ::resolveParameter
     * @covers ::validateAndResolve
     * @covers \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException::__construct
     */
    public function testResolveParameterFailsIfUnableToValidateCallableValue()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(false))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isCallable')
            ->will($this->returnValue(true))
        ;
        
        $this->parameterToMatch
            ->expects($this->exactly(2))
            ->method('getName')
            ->will($this->returnValue(($parameterName = 'INVALID callable PARAMETER')))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('bound')
            ->with(
                $this->identicalTo($parameterName)
            )
            ->will($this->returnValue(true))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('make')
            ->with(
                $this->identicalTo($parameterName)
            )
            ->will($this->returnValue(($containedValue = 12345)))
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
    
    /**
     * @test
     * @covers ::resolveParameter
     * @covers ::validateAndResolve
     */
    public function testResolveParameterResolvesPresumablyScalarValue()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(false))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isCallable')
            ->will($this->returnValue(false))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue(null))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(($parameterName = 'VALID MISC PARAMETER')))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('bound')
            ->with(
                $this->identicalTo($parameterName)
            )
            ->will($this->returnValue(true))
        ;
        
        $this->container
            ->expects($this->once())
            ->method('make')
            ->with(
                $this->identicalTo($parameterName)
            )
            ->will($this->returnValue(($containedValue = 12345)))
        ;
        
        $this->assertSame(
            $containedValue,
            $this->strategy->resolveParameter(
                $this->container,
                $this->parameterToMatch
            )
        );
    }
    
    /**
     * @test
     * @covers ::resolveParameter
     * @covers \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException::__construct
     */
    public function testResolveParameterFailsIfNotArrayCallableOrScalar()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(false))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isCallable')
            ->will($this->returnValue(false))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue('STRING'))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(($parameterName = 'INVALID UNKNOWN PARAMETER')))
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
