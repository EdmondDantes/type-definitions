<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Value;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\TypeErrorMessage;

class ValueErrorMessage extends ValueObject
{
    public static function definition(): DefinitionMutableInterface
    {
        return (new TypeErrorMessage('errorMessage'))->asReference()->asImmutable();
    }
}
