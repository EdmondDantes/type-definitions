<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeEnum extends DefinitionAbstract
{
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        // TODO: Implement validateValue() method.
    }

    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }

    #[\Override]
    public function encode(mixed $data): mixed
    {
        // TODO: Implement encode() method.
    }

    #[\Override]
    public function decode(float|array|bool|int|string $data): mixed
    {
        // TODO: Implement decode() method.
    }
}
