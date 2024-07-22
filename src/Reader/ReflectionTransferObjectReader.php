<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\NativeSerialization\AttributeNameInterface;
use IfCastle\TypeDefinitions\Resolver\ResolverInterface;
use IfCastle\TypeDefinitions\Resolver\TypeContext;
use IfCastle\TypeDefinitions\Resolver\TypeContextInterface;
use IfCastle\TypeDefinitions\TypeObject;

class ReflectionTransferObjectReader
{
    public function __construct(protected string|object $object, protected readonly ResolverInterface $resolver) {}
    
    public function generate(): DefinitionMutableInterface
    {
        $classReflection            = new \ReflectionClass($this->object);
        
        $objectDescriptor           = new TypeObject($classReflection->getName());
        
        foreach ($classReflection->getProperties() as $property) {
            $typeContext            = new TypeContext(
                className:          $classReflection->getName(),
                propertyName:       $property->getName(),
                attributes:         $this->extractAttributes($property),
                isProperty:         true
            );
            
            $typeReader             = $this->buildTypeReader($property, $typeContext);
            
            $objectDescriptor->describe($typeReader->generate());
        }
        
        return $objectDescriptor->asImmutable();
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
        
        foreach ($reflector->getAttributes(AttributeNameInterface::class, \ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $attributes[]           = $attribute->newInstance();
        }
        
        return $attributes;
    }
}