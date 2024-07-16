<?php

namespace IfCastle\TypeDefinitions\Value;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\TypeInteger;

class ValueNumber                   extends ValueContainer
{
    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return new TypeInteger('number');
    }
}