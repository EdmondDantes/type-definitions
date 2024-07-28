<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DecodingException;
use IfCastle\TypeDefinitions\Exceptions\EncodingException;

class TypeDateTime                  extends DefinitionAbstract
                                    implements StringableInterface
{
    protected string|null $pattern      = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1]) (2[0-3]|[01]\d):[0-5]\d:[0-5]\d$/';
    
    protected string|null $ecmaPattern  = '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]';
    
    protected bool $dateAsImmutable     = true;
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'datetime', $isRequired, $isNullable);
    }
    
    public function dateAsImmutable(): static
    {
        $this->dateAsImmutable          = true;
        
        return $this;
    }
    
    public function dateAsMutable(): static
    {
        $this->dateAsImmutable          = false;
        
        return $this;
    }
    
    #[\Override]
    public function isBinary(): bool
    {
        return false;
    }
    
    #[\Override]
    public function getMaxLength(): int|null
    {
        return 19;
    }
    
    #[\Override]
    public function getMinLength(): int|null
    {
        return 19;
    }
    
    #[\Override]
    public function getPattern(): string|null
    {
        return $this->pattern;
    }
    
    #[\Override]
    public function getEcmaPattern(): string|null
    {
        return $this->ecmaPattern;
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        if($value instanceof \DateTime || $value instanceof \DateTimeImmutable) {
            return true;
        }
        
        if(false === \DateTime::createFromFormat('Y-m-d H:i:s', $value)) {
            return false;
        }
        
        return true;
    }

    #[\Override]
    public function encode(mixed $data): mixed
    {
        if($data instanceof \DateTimeImmutable || $data instanceof \DateTime) {
            return $data->format('Y-m-d H:i:s');
        }
        
        throw new EncodingException($this, 'Invalid datetime format. Expected DateTime or DateTimeImmutable', ['data' => $data]);
    }

    #[\Override]
    public function decode(float|array|bool|int|string $data): mixed
    {
        if(is_string($data)) {
            $data                  = \DateTime::createFromFormat('Y-m-d H:i:s', $data);
        }
        
        if($data instanceof \DateTimeImmutable) {
            return $data;
        }
        
        if($data instanceof \DateTime) {
            return \DateTimeImmutable::createFromMutable($data);
        }
        
        throw new DecodingException($this, 'Invalid date format.', ['data' => $data]);
    }
}