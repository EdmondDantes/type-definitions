<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

interface AttributesInterface
{
    /**
     * @param string|null $name
     * @return array<object>
     */
    public function getAttributes(?string $name = null): array;

    public function findAttribute(string $name): object|null;
}
