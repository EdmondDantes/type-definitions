<?php

namespace IfCastle\TypeDefinitions;

/**
 * Enum with human-readable simple types
 */
class TypeStringNumberFloat         extends TypeOneOf
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
    
        $this->describeCase(new TypeString('string'))
            ->describeCase(new TypeNumber('number'))
            ->describeCase(new TypeFloat('float'));
    }
}