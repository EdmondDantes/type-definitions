<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\Exceptions\DescribeException;
use IfCastle\TypeDefinitions\Function\FunctionDescriptorInterface;

class ReflectionFunctionReader implements FunctionReaderInterface
{
    public function extractFunctionDescriptor(string|\Closure $function): FunctionDescriptorInterface
    {
        $reflectionFunction         = new \ReflectionFunction($function);
        
        
    }
    
    public function extractMethodDescriptor(string $class, string $method): FunctionDescriptorInterface
    {
        // TODO: Implement extractMethodDescriptor() method.
    }
    
    protected function extractParameters(\ReflectionFunction $reflectionFunction): void
    {
        foreach ($reflectionFunction->getParameters() as $parameter) {
            $parameterType          = $parameter->getType();
            $parameterName          = $parameter->getName();
        }
    }
    
    protected function extractParameter(\ReflectionParameter $reflectionParameter): void
    {
        $parameterType              = $reflectionParameter->getType();
        $parameterName              = $reflectionParameter->getName();
        
        if($parameterType === null) {
            return;
        }
        
        if($parameterType instanceof \ReflectionUnionType) {
            $parameterTypes         = $parameterType->getTypes();
        } else if($parameterType instanceof \ReflectionIntersectionType) {
            $parameterTypes         = $parameterType->getTypes();
        } else {
            $parameterTypes         = [$parameterType];
        }
        
    }
}