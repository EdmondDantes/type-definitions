<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Resolver;

interface TypeContextInterface
{
    public function getClassName(): string|null;
    public function getFunctionName(): string|null;
    public function getParameterName(): string|null;
    public function getPropertyName(): string|null;
    public function isReturnType(): bool;
    public function isParameter(): bool;
    public function isProperty(): bool;
}