<?php

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionTypeInvalid;

class TypeListWithComma             extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::LIST_WITH_COMMA, $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return is_array($value) || is_string($value);
    }
    
    #[\Override]
    public function encode(mixed $data): mixed
    {
        return $data;
    }

    /**
     * @throws DefinitionTypeInvalid
     */
    #[\Override]
    public function decode(array|int|float|string|bool $data): mixed
    {
        if (is_string($data)) {
            return explode(',', $data);
        }
        
        if (is_array($data)) {
            return $data;
        }

        throw new DefinitionTypeInvalid($this, self::LIST_WITH_COMMA.' should be string or array');
    }
}