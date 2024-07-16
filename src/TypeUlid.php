<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeUlid                      extends TypeString
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        
        $this->type                 = self::TYPE_ULID;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return parent::validateValue($value) && preg_match(Resource::PREG_UUID, (string) $value);
    }
}