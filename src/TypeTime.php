<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeTime                      extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'time', $isRequired, $isNullable);
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