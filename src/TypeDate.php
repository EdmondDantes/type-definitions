<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeDate                      extends DefinitionAbstract
{
    protected string|null $pattern      = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/';
    
    protected string|null $ecmaPattern  = '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])';
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::TYPE_DATE, $isRequired, $isNullable);
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
        // TODO: Implement arrayEncode() method.
    }

    #[\Override]
    public function decode(float|array|bool|int|string $data): mixed
    {
        // TODO: Implement arrayDecode() method.
    }
}