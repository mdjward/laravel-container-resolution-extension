<?php
/**
 * GivenParametersStrategyTest.php
 * Definition of class GivenParametersStrategyTest
 * 
 * Created 23-Apr-2016 08:32:28
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * GivenParametersStrategyTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * @coversDefaultClass \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\GivenParametersStrategy
 */
class GivenParametersStrategyTest extends AbstractStrategyTestCase
{

    /**
     *
     * @var GivenParametersStrategy
     */
    protected $strategy;
    
    /**
     *
     * @var type 
     */
    protected $parameterName;

    
    
    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->strategy = new GivenParametersStrategy();
    }

    /**
     * @test
     * @covers ::resolveParameter
     */
    public function testResolveParameterReturnsGivenParameterIfFound()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will(
                $this->returnValue(($this->parameterName = 'PARAMETER NAME'))
            )
        ;
        
        $this->assertSame(
            12345,
            $this->strategy->resolveParameter(
                $this->container,
                $this->parameterToMatch,
                [
                    $this->parameterName => 12345
                ],
                []
            )
        );
    }
    
    /**
     * @test
     * @covers ::resolveParameter
     */
    public function testResolveParameterReturnsGivenPrimitiveIfFound()
    {
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will(
                $this->returnValue(($this->parameterName = 'PARAMETER NAME'))
            )
        ;
        
        $this->assertSame(
            12345,
            $this->strategy->resolveParameter(
                $this->container,
                $this->parameterToMatch,
                [
                    $this->parameterName => 12345
                ],
                []
            )
        );
    }
    
    /**
     * @test
     * @covers ::resolveParameter
     * @covers \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException::__construct
     */
    public function testResolveParameterThrowsExceptionIfNothingIsFound()
    {
        $this->parameterToMatch
            ->expects($this->exactly(2))
            ->method('getName')
            ->will(
                $this->returnValue(($this->parameterName = 'PARAMETER NAME'))
            )
        ;
        
        $this->setExpectedException(
            ResolutionFailedException::class,
            "Failed to resolve parameter " . $this->parameterName
        );
        
        $this->strategy->resolveParameter(
            $this->container,
            $this->parameterToMatch,
            [],
            []
        );
    }

}
