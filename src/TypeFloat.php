<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DecodingException;
use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;
use IfCastle\TypeDefinitions\Exceptions\EncodingException;
use IfCastle\TypeDefinitions\Value\ValueFloat;

class TypeFloat                     extends DefinitionAbstract
                                    implements NumberMutableInterface
{
    protected float|null $minimum   = null;
    
    protected float|null $maximum   = null;
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'float', $isRequired, $isNullable);
    }
    
    public function isUnsigned(): bool
    {
        return $this->minimum !== null && $this->minimum >= 0;
    }
    
    public function isNonZero(): bool
    {
        return $this->minimum !== null && $this->minimum > 0;
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
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
        $this->minimum              = (float)$minimum;
        return $this;
    }
    
    public function setMaximum(int|float $maximum): static
    {
        $this->maximum              = (float)$maximum;
        return $this;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        if(!is_numeric($value)) {
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
    public function encode(mixed $data): mixed
    {
        if(is_float($data)) {
            return $data;
        }
        
        if(is_numeric($data)) {
            return (float)$data;
        }
        
        if($data instanceof ValueFloat) {
            return $data->getValue();
        }
        
        throw new EncodingException($this, 'Value is not a float', ['data' => $data]);
    }

    /**
     * @throws DefinitionIsNotValid
     */
    #[\Override]
    public function decode(array|int|float|string|bool $data): mixed
    {
        if(is_string($data)) {
            
            if(!preg_match('/^[+-]?[0-9]+(\.[0-9]+)?(e[+-]?[0-9]+)?$/', $data)) {
                throw new DecodingException($this, 'Value is not a float', ['data' => $data]);
            }
            
            $data                  = (float)$data;
        }
        
        if(is_bool($data) || is_int($data)) {
            $data                  = (float)$data;
        }
        
        if(!is_float($data)) {
            throw new DecodingException($this, 'Value is not a float', ['data' => $data]);
        }
        
        if($this->minimum !== null && $data < $this->minimum) {
            throw new DecodingException($this, 'Value is less than minimum', ['data' => $data]);
        }
        
        if($this->maximum !== null && $data > $this->maximum) {
            throw new DecodingException($this, 'Value is greater than maximum', ['data' => $data]);
        }
        
        return $data;
    }
}