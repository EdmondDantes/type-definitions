<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

interface AttributesInterface
{
    public function getAttributes(string $name = null): array;
    
    public function findAttribute(string $name): object|null;
}