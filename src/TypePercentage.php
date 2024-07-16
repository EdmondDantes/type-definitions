<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypePercentage                extends TypeInteger
{
    protected int|float|null $maximum = 100;
    
    protected int|float|null $minimum = 0;
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return parent::validateValue($value) && $value >= 0 && $value <= 100;
    }
}