<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\FunctionDescriptorInterface;
use IfCastle\TypeDefinitions\NativeSerialization\AttributeNameInterface;
use IfCastle\TypeDefinitions\Resolver\ResolverInterface;
use IfCastle\TypeDefinitions\Resolver\TypeContext;
use IfCastle\TypeDefinitions\Resolver\TypeContextInterface;
use IfCastle\TypeDefinitions\TypeFunction;

class ReflectionFunctionReader      implements FunctionReaderInterface
{
    public function __construct(protected readonly ResolverInterface $resolver) {}
    
    public function extractFunctionDescriptor(string|\Closure $function): FunctionDescriptorInterface
    {
        $reflectedFunction          = new \ReflectionFunction($function);
        
        $functionDescriptor         = new TypeFunction($reflectedFunction->getName());
        
        foreach ($reflectedFunction->getParameters() as $parameter) {
            
            $typeContext            = new TypeContext(
                functionName:       $reflectedFunction->getName(),
                parameterName:      $parameter->getName(),
                attributes:         $this->extractAttributes($parameter),
                isParameter:        true
            );
            
            $typeReader             = $this->buildTypeReader($parameter, $typeContext);
            
            $functionDescriptor->describe($typeReader->generate());
        }
        
        $typeContext                = new TypeContext(
            functionName:           $reflectedFunction->getName(),
            attributes:             $this->extractAttributes($reflectedFunction),
            isReturnType:           true
        );
        
        $typeReader                 = $this->buildTypeReader($reflectedFunction->getReturnType(), $typeContext);
        
        $functionDescriptor->describeReturnType($typeReader->generate());
        
        return $functionDescriptor->asImmutable();
    }
    
    public function extractMethodDescriptor(string|object $object, string $method): FunctionDescriptorInterface
    {
        $reflectedMethod            = new \ReflectionMethod($object, $method);
        $reflectedClass             = $reflectedMethod->getDeclaringClass();
        
        $methodDescriptor           = new TypeFunction(
            name:       $reflectedMethod->getName(),
            className:  $reflectedClass->getName(),
            isStatic:   $reflectedMethod->isStatic()
        );
        
        foreach ($reflectedMethod->getParameters() as $parameter) {
            
            $typeContext            = new TypeContext(
                className:          $reflectedClass->getName(),
                functionName:       $reflectedMethod->getName(),
                parameterName:      $parameter->getName(),
                attributes:         $this->extractAttributes($parameter),
                isParameter:        true
            );
            
            $typeReader             = $this->buildTypeReader($parameter, $typeContext);
            
            $methodDescriptor->describe($typeReader->generate());
        }
        
        $typeContext                = new TypeContext(
            functionName:           $methodDescriptor->getName(),
            attributes:             $this->extractAttributes($reflectedMethod),
            isReturnType:           true
        );
        
        $typeReader                 = $this->buildTypeReader($reflectedMethod->getReturnType(), $typeContext);
        
        $methodDescriptor->describeReturnType($typeReader->generate());
        
        return $methodDescriptor->asImmutable();
    }
    
    protected function buildTypeReader(\ReflectionType|\ReflectionParameter|null $reflectionType, TypeContextInterface $typeContext): ReflectionTypeReader
    {
        return new ReflectionTypeReader($reflectionType, $typeContext, $this->resolver);
    }
    
    protected function extractAttributes(\Reflector $reflector): array
    {
        if(false === method_exists($reflector, 'getAttributes')) {
            return [];
        }
        
        $attributes                 = [];
        
        foreach ($reflector->getAttributes(AttributeNameInterface::class, \ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $attributes[]           = $attribute->newInstance();
        }

        return $attributes;
    }
    
}