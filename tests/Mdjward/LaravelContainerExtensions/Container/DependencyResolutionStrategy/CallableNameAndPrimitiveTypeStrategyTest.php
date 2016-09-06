<?php
/**
 * CallableNameAndPrimitiveTypeStrategyTest.php
 * Definition of class CallableNameAndPrimitiveTypeStrategyTest
 *
 * Created 06-Sep-2016, 10:11:08 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * CallableNameAndPrimitiveTypeStrategyTest
 *
 * @author M.D.Ward <md.ward@quidco.com>
 * @coversDefaultClass Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\CallableNameAndPrimitiveTypeStrategy
 */
class CallableNameAndPrimitiveTypeStrategyTest extends AbstractNameAndPrimitiveTypeStrategyTestCase
{

    /**
     *
     * @var CallableNameAndPrimitiveTypeStrategy
     */
    private $strategy;
    


    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();

        $this->strategy = new CallableNameAndPrimitiveTypeStrategy();
    }

    /**
     * @test
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::resolveParameter
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::extractContainedValue
     * @covers ::acceptParameter
     */
    public function testResolveParameterFailsWhenParameterIsNotCallableTypeHint()
    {
        $this->setUpParameterToMatch(2);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('isCallable')
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
     * @covers ::acceptParameter
     * @covers ::acceptValue
     */
    public function testResolveParameterFailsToMatchWhenParameterValueIsNotCallable()
    {
        $this->setUpParameterToMatch(2);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('isCallable')
            ->will($this->returnValue(true))
        ;

        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue("NOT CALLABLE"))
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
     * @covers ::acceptParameter
     * @covers ::acceptValue
     */
    public function testResolveParameterResolvesParameterWhenOfCorrectType()
    {
        $this->setUpParameterToMatch(1);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('isCallable')
            ->will($this->returnValue(true))
        ;

        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(($value = function() {})))
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
