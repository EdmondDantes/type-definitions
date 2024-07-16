<?php

namespace IfCastle\TypeDefinitions\Value;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\TypeNumber;

class ValueNumber                   extends ValueContainer
{
    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return new TypeNumber('number');
    }
}