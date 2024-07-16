<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;

class TypeString                    extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::TYPE_STRING, $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        if(!is_scalar($value)) {
            return false;
        }
        
        if($this->minLength !== null && strlen($value) < $this->minLength) {
            return false;
        }
    
        if($this->maxLength !== null && strlen($value) > $this->maxLength) {
            return false;
        }

        if($this->pattern !== null && !preg_match($this->pattern, $value)) {
            return false;
        }
        
        return true;
    }

    /**
     * @throws DefinitionIsNotValid
     */
    #[\Override]
    public function decode(mixed $data): mixed
    {
        if(is_string($data)) {
            return $data;
        }
        
        if(is_scalar($data)) {
            return (string)$data;
        }
        
        throw new DefinitionIsNotValid($this, 'value is not a string');
    }
    
    #[\Override]
    public function encode(mixed $data): mixed
    {
        return (string) $data;
    }
}