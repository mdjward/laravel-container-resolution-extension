<?php
/**
 * ArrayNameAndPrimitiveTypeStrategyTest.php
 * Definition of class ArrayNameAndPrimitiveTypeStrategyTest
 *
 * Created 06-Sep-2016, 10:11:08 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * ArrayNameAndPrimitiveTypeStrategyTest
 *
 * @author M.D.Ward <md.ward@quidco.com>
 * @coversDefaultClass Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ArrayNameAndPrimitiveTypeStrategy
 */
class ArrayNameAndPrimitiveTypeStrategyTest extends AbstractNameAndPrimitiveTypeStrategyTestCase
{

    /**
     *
     * @var ArrayNameAndPrimitiveTypeStrategy
     */
    private $strategy;
    


    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();

        $this->strategy = new ArrayNameAndPrimitiveTypeStrategy();
    }

    /**
     * @test
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::resolveParameter
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::extractContainedValue
     * @covers ::isAcceptableParameter
     */
    public function testResolveParameterFailsWhenParameterIsNotArrayTypeHint()
    {
        $this->setUpParameterToMatch(2);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(false))
        ;

        $this->expectException(ResolutionFailedException::class);
        $this->expectExceptionMessage('Failed to resolve parameter ' . $this->parameterName);
        
        $this->strategy->resolveParameter(
            $this->container,
            $this->parameterToMatch
        );
    }
    
    /**
     * @test
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::resolveParameter
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::extractContainedValue
     * @covers ::isAcceptableParameter
     * @covers ::isAcceptableValue
     */
    public function testResolveParameterFailsToMatchWhenParameterValueIsNotArray()
    {
        $this->setUpParameterToMatch(2);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(true))
        ;

        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue("NOT AN ARRAY"))
        ;

        $this->expectException(ResolutionFailedException::class);
        $this->expectExceptionMessage('Failed to resolve parameter ' . $this->parameterName);

        $this->strategy->resolveParameter(
            $this->container,
            $this->parameterToMatch
        );
    }
    
    /**
     * @test
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::resolveParameter
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::extractContainedValue
     * @covers ::isAcceptableParameter
     * @covers ::isAcceptableValue
     */
    public function testResolveParameterResolvesParameterWhenOfCorrectType()
    {
        $this->setUpParameterToMatch(1);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('isArray')
            ->will($this->returnValue(true))
        ;

        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(($value = [1,2,3])))
        ;

        $this->assertSame(
            $value,
            $this->strategy->resolveParameter(
                $this->container,
                $this->parameterToMatch
            )
        );
    }

}
