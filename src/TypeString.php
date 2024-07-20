<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;

class TypeString                    extends DefinitionAbstract
                                    implements StringableMutableInterface
{
    protected int|null $minLength   = null;
    protected int|null $maxLength   = null;
    
    protected string|null $pattern  = null;
    
    /**
     * Additional variant of the regular expression according to the Ecma standard.
     * @see https://262.ecma-international.org/5.1/#sec-15.10.1
     */
    protected string|null $ecmaPattern  = null;
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'string', $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    public function isBinary(): bool
    {
        return false;
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
    
    public function getMaxLength(): int|null
    {
        return $this->maxLength;
    }
    
    public function getMinLength(): int|null
    {
        return $this->minLength;
    }
    
    public function getPattern(): string|null
    {
        return $this->pattern;
    }
    
    public function getEcmaPattern(): string|null
    {
        return $this->ecmaPattern;
    }
    
    public function setMaxLength(int $maxLength): static
    {
        $this->maxLength = $maxLength;
        
        return $this;
    }
    
    public function setMinLength(int $minLength): static
    {
        $this->minLength = $minLength;
        
        return $this;
    }
    
    public function setPattern(string $pattern): static
    {
        $this->pattern = $pattern;
        
        return $this;
    }
    
    public function setEcmaPattern(string $ecmaPattern): static
    {
        $this->ecmaPattern = $ecmaPattern;
        
        return $this;
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