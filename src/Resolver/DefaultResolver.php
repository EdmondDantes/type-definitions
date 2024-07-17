<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Resolver;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;

class DefaultResolver implements ResolverInterface
{
    public function resolveType(string $typeName, TypeContextInterface $typeContext): DefinitionMutableInterface
    {
        // TODO: Implement resolveType() method.
    }
}