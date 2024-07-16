<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;

class TypeNumber                   extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::TYPE_NUMBER, $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
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