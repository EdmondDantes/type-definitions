<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Resolver;

readonly class TypeContext implements TypeContextInterface
{
    public function __construct(
        private string|null $className      = null,
        private string|null $functionName   = null,
        private string|null $parameterName  = null,
        private string|null $propertyName   = null,
        private array $attributes           = [],
        private bool $isReturnType          = false,
        private bool $isParameter           = false,
        private bool $isProperty            = false
    ) {}


    public function getClassName(): string|null
    {
        return $this->className;
    }

    public function getFunctionName(): string|null
    {
        return $this->functionName;
    }

    public function getParameterName(): string|null
    {
        return $this->parameterName;
    }

    public function getPropertyName(): string|null
    {
        return $this->propertyName;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $attribute): mixed
    {
        foreach ($this->attributes as $attr) {
            if (\is_subclass_of($attr, $attribute)) {
                return $attr;
            }
        }

        return null;
    }

    public function hasAttribute(string $attribute): bool
    {
        foreach ($this->attributes as $attr) {
            if (\is_subclass_of($attr, $attribute)) {
                return true;
            }
        }

        return false;
    }

    public function isReturnType(): bool
    {
        return $this->isReturnType;
    }

    public function isParameter(): bool
    {
        return $this->isParameter;
    }

    public function isProperty(): bool
    {
        return $this->isProperty;
    }
}
