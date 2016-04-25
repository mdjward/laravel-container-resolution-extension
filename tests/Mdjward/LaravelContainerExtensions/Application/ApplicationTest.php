<?php

/**
 * ApplicationTest.php
 * Definition of class ApplicationTest
 * 
 * Created 24-Apr-2016 16:42:59
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Application;

use Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException;
use Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionStrategyInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionMethod;
use ReflectionObject;
use ReflectionParameter;



/**
 * ApplicationTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * @coversDefaultClass \Mdjward\LaravelContainerExtensions\Application\Application
 */
class ApplicationTest extends TestCase
{
    
    /**
     *
     * @var MockObject
     */
    private $resolutionStrategy;
    
    /**
     *
     * @var Application
     */
    private $application;
    
    /**
     *
     * @var ReflectionMethod
     */
    private $getDependenciesMethod;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        $this->resolutionStrategy = $this->getMockForAbstractClass(
            ResolutionStrategyInterface::class
        );
        
        $this->application = new Application(null, [$this->resolutionStrategy]);
        
        $applicationReflection = new ReflectionObject($this->application);

        $this->getDependenciesMethod = $applicationReflection->getMethod('getDependencies');
        $this->getDependenciesMethod->setAccessible(true);
    }
    
    /**
     * @test
     * @covers ::__construct
     * @covers ::setDependencyResolutionStrategies
     * @covers ::addDependencyResolutionStrategy
     * @covers ::getDependencies
     * @covers ::resolveDependency
     */
    public function testGetDependencies()
    {
        $parameters = [null, null];
        
        foreach ($parameters as &$parameter) {
            $parameter = $this
                ->getMockBuilder(ReflectionParameter::class)
                ->disableOriginalConstructor()
                ->getMock()
            ;
        }

        $this->resolutionStrategy
            ->expects($this->at(0))
            ->method('resolveParameter')
            ->with(
                $this->identicalTo($this->application),
                $this->identicalTo($parameters[0]),
                $this->identicalTo([])
            )
            ->will($this->returnValue(($returnedValue = 12345)))
        ;
        
        $this->resolutionStrategy
            ->expects($this->at(1))
            ->method('resolveParameter')
            ->with(
                $this->identicalTo($this->application),
                $this->identicalTo($parameters[1]),
                $this->identicalTo([])
            )
            ->will(
                $this->throwException(
                    new ResolutionFailedException(
                        $this->getMockBuilder(ReflectionParameter::class)
                            ->disableOriginalConstructor()
                            ->getMock()
                    )
                )
            )
        ;

        $this->assertSame(
            [$returnedValue, null],
            $this->getDependenciesMethod->invokeArgs(
                $this->application,
                [
                    $parameters,
                    []
                ]
            )
        );
    }
    
    /**
     * @test
     * @covers ::setDependencyResolutionStrategies
     * @covers ::addDependencyResolutionStrategy
     * @covers ::getDependencies
     * @covers ::resolveDependency
     */
    public function testGetDependenciesThrowsExceptionIfNoStrategiesAreSet()
    {
        $parameter = $this
            ->getMockBuilder(ReflectionParameter::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $parameter
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(($parameterName = 'PARAMETER NAME')))
        ;

        $this->application->setDependencyResolutionStrategies([]);

        $this->assertSame(
            [null],
            $this->getDependenciesMethod->invokeArgs(
                $this->application,
                [
                    [$parameter],
                    []
                ]
            )
        );
    }
    
}
