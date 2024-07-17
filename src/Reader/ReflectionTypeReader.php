<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\DefinitionAbstract;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;

class ReflectionTypeReader
{
    public function __construct(protected readonly \ReflectionParameter|\ReflectionProperty|\ReflectionType $definition) {}
    
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
    
    protected function handleNamedType(\ReflectionNamedType $type): DefinitionMutableInterface|null
    {
        if($type->isBuiltin()) {
            return DefinitionAbstract::getDefinitionByNativeTypeName($type->getName(), '');
        }
        
        // Try understanding the type class or interface
        $reflectionClass            = new \ReflectionClass($type->getName());
        
        
        
    }
}