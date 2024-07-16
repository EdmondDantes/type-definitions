<?php

namespace IfCastle\TypeDefinitions;

class TypeNull                      extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true)
    {
        parent::__construct($name, self::TYPE_NULL, $isRequired);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return $value === null;
    }

    #[\Override]
    public function encode(mixed $data): mixed
    {
        return null;
    }

    #[\Override]
    public function decode(float|int|bool|array|string $data): mixed
    {
        return null;
    }
}