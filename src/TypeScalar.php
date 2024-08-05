<?php

namespace IfCastle\TypeDefinitions;

/**
 * Enum with human-readable simple types
 */
class TypeScalar         extends TypeOneOf
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
    
        $this->describeCase(new TypeBool('boolean'))
            ->describeCase(new TypeString('string'))
            ->describeCase(new TypeInteger('number'))
            ->describeCase(new TypeFloat('float'));
    }
    
    #[\Override]
    public function canDecodeFromString(): bool
    {
        return true;
    }
}