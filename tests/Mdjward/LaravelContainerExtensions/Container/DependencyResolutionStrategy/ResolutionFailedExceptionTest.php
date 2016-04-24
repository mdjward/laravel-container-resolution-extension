<?php

/**
 * ResolutionFailedExceptionTest.php
 * Definition of class ResolutionFailedExceptionTest
 * 
 * Created 24-Apr-2016 16:38:33
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * Copyright (c) 2016, 
 */

namespace Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy;



/**
 * ResolutionFailedExceptionTest
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 * @coversDefaultClass \Mdjward\LaravelContainerExtensions\Container\DependencyResolutionStrategy\ResolutionFailedException
 */
class ResolutionFailedExceptionTest extends AbstractStrategyTestCase
{
    
    /**
     *
     * @var ResolutionFailedException
     */
    private $exception;
    
    /**
     *
     * @var string
     */
    private $parameterName = 'PARAMETER NAME';
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->parameterToMatch
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($this->parameterName))
        ;
        
        $this->exception = new ResolutionFailedException(
            $this->parameterToMatch
        );
    }
    
    /**
     * 
     * @test ::__construct
     * @test ::getParameter
     */
    public function testGetParameter()
    {
        $this->assertSame(
            $this->parameterToMatch,
            $this->exception->getParameter()
        );
        
        $this->assertSame(
            "Failed to resolve parameter " . $this->parameterName,
            $this->exception->getMessage()
        );
    }
    
}
