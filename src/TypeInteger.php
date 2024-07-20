<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;

class TypeInteger                   extends DefinitionAbstract
                                    implements NumberMutableInterface
{
    protected int|null $minimum     = null;
    
    protected int|null $maximum     = null;
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'integer', $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    public function isUnsigned(): bool
    {
        return $this->minimum !== null && $this->minimum >= 0;
    }
    
    public function isNonZero(): bool
    {
        return $this->minimum !== null && $this->minimum > 0;
    }
    
    public function getMinimum(): int|float|null
    {
        return $this->minimum;
    }
    
    public function getMaximum(): int|float|null
    {
        return $this->maximum;
    }
    
    public function setMinimum(int|float $minimum): static
    {
        $this->minimum              = (int)$minimum;
        return $this;
    }
    
    public function setMaximum(int|float $maximum): static
    {
        $this->maximum              = (int)$maximum;
        return $this;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        if(!is_numeric($value) || str_contains(strtolower($value), 'e')) {
            return false;
        }
        
        if($this->minimum !== null && $value < $this->minimum) {
            return false;
        }
    
        if($this->maximum !== null && $value > $this->maximum) {
            return false;
        }
        
        return true;
    }
    
    #[\Override]
    public function decode(array|int|float|string|bool $data): mixed
    {
        if (is_numeric($data)) {
            return (int)$data;
        }
        
        throw new DefinitionIsNotValid($this, 'Type is invalid');
    }
    
    #[\Override]
    public function encode(mixed $data): mixed
    {
        return $data;
    }
}