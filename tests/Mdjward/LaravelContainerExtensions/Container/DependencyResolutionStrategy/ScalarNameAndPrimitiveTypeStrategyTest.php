<?php
/**
 * ScalarNameAndPrimitiveTypeStrategyTest.php
 * Definition of class ScalarNameAndPrimitiveTypeStrategyTest
 *
 * Created 06-Sep-2016, 10:11:08 PM
 * 
 * @author M.D.Ward <md.ward@quidco.com>
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * ScalarNameAndPrimitiveTypeStrategyTest
 *
 * @author M.D.Ward <md.ward@quidco.com>
 * @coversDefaultClass Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ScalarNameAndPrimitiveTypeStrategy
 */
class ScalarNameAndPrimitiveTypeStrategyTest extends AbstractNameAndPrimitiveTypeStrategyTestCase
{

    /**
     *
     * @var ScalarNameAndPrimitiveTypeStrategy
     */
    private $strategy;
    


    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();

        $this->strategy = new ScalarNameAndPrimitiveTypeStrategy();
    }

    /**
     * @test
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::resolveParameter
     * @covers Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\AbstractNameAndPrimitiveTypeStrategy::extractContainedValue
     * @covers ::acceptParameter
     */
    public function testResolveParameterFailsWhenParameterIsNotScalarTypeHint()
    {
        $this->setUpParameterToMatch(2);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue(\stdClass::class))
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
    public function testResolveParameterFailsToMatchWhenParameterValueIsNotScalar()
    {
        $this->setUpParameterToMatch(2);

        $this->parameterToMatch
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue(null))
        ;

        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(new \stdClass()))
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
            ->method('getClass')
            ->will($this->returnValue(null))
        ;

        $this->container
            ->expects($this->once())
            ->method('make')
            ->with($this->identicalTo($this->parameterName))
            ->will($this->returnValue(($value = "SCALAR VALUE")))
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
