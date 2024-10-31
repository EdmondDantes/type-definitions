<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Value;

interface ContainerSerializableInterface
{
    /**
     * Serialize container to a simple type which can be converted to JSON.
     */
    public function containerSerialize(): array|string|bool|int|float|null;
    public function containerToString(): string;
}
