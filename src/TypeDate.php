<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DecodingException;
use IfCastle\TypeDefinitions\Exceptions\EncodingException;

class TypeDate                      extends TypeString
{
    protected string|null $pattern      = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/';
    
    protected string|null $ecmaPattern  = '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])';
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        $this->type                     = 'date';
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
        
        if(false === \DateTime::createFromFormat('Y-m-d', $value)) {
            return false;
        }
        
        return true;
    }

    #[\Override]
    public function encode(mixed $data): mixed
    {
        if($data instanceof \DateTimeImmutable || $data instanceof \DateTime) {
            return $data->format('Y-m-d');
        }
        
        throw new EncodingException($this, 'Invalid date format. Expected DateTime or DateTimeImmutable', ['data' => $data]);
    }

    #[\Override]
    public function decode(array|int|float|string|bool $data): mixed
    {
        if(is_string($data)) {
            $data                  = \DateTimeImmutable::createFromFormat('Y-m-d', $data);
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