<?php

namespace IfCastle\TypeDefinitions;

class TypeMixed                     extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::TYPE_MIXED, $isRequired, $isNullable);
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return true;
    }

    #[\Override]
    public function encode(mixed $data): mixed
    {
        return $data;
    }

    #[\Override]
    public function decode(float|array|bool|int|string $data): mixed
    {
        return $data;
    }
}