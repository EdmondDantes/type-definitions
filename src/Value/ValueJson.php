<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Value;

use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\TypeJson;

class ValueJson                     extends ValueContainer
{
    #[\Override]
    public static function definition(): DefinitionInterface
    {
        return (new TypeJson('json'))->setInstantiableClass(static::class);
    }
}