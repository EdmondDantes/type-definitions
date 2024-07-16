<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeDateTime                  extends TypeString
{
    protected string|null $pattern      = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1]) (2[0-3]|[01]\d):[0-5]\d:[0-5]\d$/';
    
    protected string|null $ecmaPattern  = '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]';
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        
        $this->type                     = 'datetime';
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        // TODO: Implement validateValue() method.
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