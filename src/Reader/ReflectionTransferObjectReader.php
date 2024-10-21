<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\NativeSerialization\AttributeNameInterface;
use IfCastle\TypeDefinitions\Reader\Exceptions\ReaderException;
use IfCastle\TypeDefinitions\Resolver\ResolverInterface;
use IfCastle\TypeDefinitions\Resolver\TypeContext;
use IfCastle\TypeDefinitions\Resolver\TypeContextInterface;
use IfCastle\TypeDefinitions\TypeObject;
use IfCastle\TypeDefinitions\Value\InstantiateInterface;

class ReflectionTransferObjectReader
{
    public function __construct(protected string|object $object, protected readonly ResolverInterface $resolver) {}
    
    public function generate(): DefinitionMutableInterface
    {
        $classReflection            = new \ReflectionClass($this->object);
        
        $objectDescriptor           = new TypeObject($classReflection->getName());
        
        foreach ($this->extractProperties($classReflection) as $property) {
            $typeContext            = new TypeContext(
                className:          $classReflection->getName(),
                propertyName:       $property->getName(),
                attributes:         $this->extractAttributes($property),
                isProperty:         true
            );
            
            $typeReader             = $this->buildTypeReader($property, $typeContext);
            
            $definition             = $typeReader->generate();
            
            if($definition !== null) {
                $objectDescriptor->describe($definition);
            }
        }
        
        return $objectDescriptor->asImmutable();
    }
    
    protected function extractProperties(\ReflectionClass $reflectionClass): array
    {
        if(is_subclass_of($this->object, InstantiateInterface::class)) {
            return $reflectionClass->getProperties();
        }
        
        // Using only the properties that are defined in the class constructor
        $properties                 = [];
        $constructor                = $reflectionClass->getConstructor();
        
        if($constructor === null) {
            throw new ReaderException([
                'template'          => 'No constructor found for class {class}. But required for transfer object',
                'class'             => $reflectionClass->getName()
            ]);
        }
        
        $arguments                  = [];
        
        foreach ($constructor->getParameters() as $parameter) {
            $arguments[$parameter->getName()] = $parameter;
        }
        
        foreach ($reflectionClass->getProperties() as $property) {
            if(array_key_exists($property->getName(), $arguments)) {
                $properties[]       = $property;
            }
        }
        
        return $properties;
    }
    
    protected function buildTypeReader(\ReflectionProperty|null $reflectionType, TypeContextInterface $typeContext): ReflectionTypeReader
    {
        return new ReflectionTypeReader($reflectionType, $typeContext, $this->resolver);
    }
    
    protected function extractAttributes(\Reflector $reflector): array
    {
        if(false === method_exists($reflector, 'getAttributes')) {
            return [];
        }
        
        $attributes                 = [];
        
        foreach ($reflector->getAttributes() as $attribute) {
            $attributes[]           = $attribute->newInstance();
        }
        
        return $attributes;
    }
}