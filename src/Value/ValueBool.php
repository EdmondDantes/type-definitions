<?php

namespace IfCastle\TypeDefinitions\Value;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\TypeBool;

class ValueBool                     extends ValueContainer
{
    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return new TypeBool('boolean');
    }
}