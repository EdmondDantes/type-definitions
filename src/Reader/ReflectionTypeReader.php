<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\DefinitionAbstract;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\Reader\Exceptions\TypeResolveNotAllowed;
use IfCastle\TypeDefinitions\Resolver\ResolverInterface;
use IfCastle\TypeDefinitions\Resolver\TypeContextInterface;

class ReflectionTypeReader
{
    public function __construct(
        protected readonly \ReflectionParameter|\ReflectionProperty|\ReflectionType $definition,
        protected readonly TypeContextInterface $typeContext,
        protected readonly ResolverInterface $resolver
    ) {}
    
    public function generate(): void
    {
        if($this->definition instanceof \ReflectionParameter || $this->definition instanceof \ReflectionProperty) {
            $type                   = $this->definition->getType();
        } else {
            $type                   = $this->definition;
        }
        
        if($type === null) {
            throw new Exceptions\TypeUndefined($this->definition->getName());
        }
        
        if($type instanceof \ReflectionUnionType) {
            $types                  = $type->getTypes();
        } else if($type instanceof \ReflectionIntersectionType) {
            $types                  = $type->getTypes();
        } else {
            $types                  = [$type];
        }
    }
    
    /**
     * @throws TypeResolveNotAllowed
     */
    protected function handleNamedType(\ReflectionNamedType $type): DefinitionMutableInterface|null
    {
        if($this->definition instanceof \ReflectionParameter || $this->definition instanceof \ReflectionProperty) {
            $name               = $this->definition->getName();
        } else {
            $name               = 'returnType';
        }
        
        if($type->isBuiltin()) {
            return DefinitionAbstract::getDefinitionByNativeTypeName($type->getName(), $name);
        }
        
        $definition             = $this->resolver->resolveType($type->getName(), $this->typeContext);
        
        if($definition === null) {
            throw new TypeResolveNotAllowed($type->getName(), $this->typeContext);
        }
        
        // Make type mutable
        $definition             = clone $definition;
        
        $definition->setIsNullable($type->allowsNull());
        
        if($this->definition instanceof \ReflectionParameter || $this->definition instanceof \ReflectionProperty) {
            $definition->setName($this->definition->getName());
        }
        
        if($this->definition instanceof \ReflectionParameter) {
            $definition->setIsRequired(false === $this->definition->isDefaultValueAvailable());
        }
        
        if($this->definition instanceof \ReflectionProperty) {
            $definition->setIsRequired(false === $this->definition->isDefault());
        }
        
        return $definition;
    }
}