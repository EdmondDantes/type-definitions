<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Resolver;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\DefinitionStaticAwareInterface;
use IfCastle\TypeDefinitions\Type;

class DefaultResolver implements ResolverInterface
{
    public function resolveType(string $typeName, TypeContextInterface $typeContext): DefinitionMutableInterface|null
    {
        $type                       = $typeContext->getAttribute(Type::class);
        
        if($type instanceof Type) {
            return $type->definition;
        }
        
        if(is_subclass_of($typeName, DefinitionStaticAwareInterface::class)) {
            return $typeName::definition();
        }
        
        return null;
    }
}