<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeUlid                      extends TypeString
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        
        $this->type                 = 'ulid';
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return parent::validateValue($value) && preg_match('/^[0-9A-HJ-KM-NP-TV-Z]{26}$/', (string) $value);
    }
}