<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DecodeException;
use IfCastle\TypeDefinitions\Exceptions\EncodingException;
use IfCastle\TypeDefinitions\Value\ValueUuid;

class TypeUuid                      extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'uuid', $isRequired, $isNullable);
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        if(!is_string($value)) {
            return false;
        }
        
        // match UUID format
        return (bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    /**
     * @throws EncodingException
     */
    #[\Override]
    public function encode(mixed $data): mixed
    {
        if($data instanceof ValueUuid) {
            return $data->getValue();
        }
        
        throw new EncodingException($this, 'Only ValueUuid values can be encoded');
    }
    
    /**
     * @throws DecodeException
     */
    #[\Override]
    public function decode(float|array|bool|int|string $data): mixed
    {
        $this->validate($data);
        
        return new ValueUuid($data);
    }
}