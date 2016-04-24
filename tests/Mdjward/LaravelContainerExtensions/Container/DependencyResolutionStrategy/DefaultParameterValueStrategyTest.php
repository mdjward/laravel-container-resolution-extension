<?php

/**
 * DefaultParameterValueStrategyTest.php
 * Definition of class DefaultParameterValueStrategyTest
 * 
 * Created 22-Apr-2016 09:00:58
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * DefaultParameterValueStrategyTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * @coversDefaultClass \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\DefaultParameterValueStrategy
 */
class DefaultParameterValueStrategyTest extends AbstractStrategyTestCase
{
    
    /**
     *
     * @var DefaultParameterValueStrategy
     */
    private $strategy;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->strategy = new DefaultParameterValueStrategy();
    }
    
    /**
     * @test
     * @covers ::resolveParameter
     */
    public function testResolveParameterReturnsDefaultValueIfAvailable()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isDefaultValueAvailable')
            ->will($this->returnValue(true))
        ;
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getDefaultValue')
            ->will($this->returnValue(($returnValue = "RETURN VALUE")))
        ;
        
        $this->assertSame(
            $returnValue,
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
    public function testResolveParameterThrowsExceptionIfUnableToResolve()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('isDefaultValueAvailable')
            ->will($this->returnValue(false))
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
