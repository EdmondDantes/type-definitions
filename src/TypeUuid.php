<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DecodingException;
use IfCastle\TypeDefinitions\Exceptions\EncodingException;
use IfCastle\TypeDefinitions\Value\ValueUuid;

class TypeUuid                      extends TypeString
{
    final const string PREG_UUID    = '/^{?[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}}?$/i';
    
    public static function nullGuid(): string
    {
        return '00000000-0000-0000-0000-000000000000';
    }
    
    public static function maxGuid(): string
    {
        return 'ffffffff-ffff-ffff-ffff-ffffffffffff';
    }
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        $this->type                 = 'uuid';
    }
    
    public function decode(array|int|float|string|bool $data): mixed
    {
        if(!is_string($data) || !preg_match(self::PREG_UUID, $data)) {
            throw new DecodingException($this, 'Expected string with UUID format');
        }
        
        return new ValueUuid(parent::decode($data));
    }
    
    /**
     * @throws EncodingException
     */
    public function encode(mixed $data): mixed
    {
        if(is_string($data)) {
            return $data;
        }
        
        if($data instanceof ValueUuid) {
            return $data->getValue();
        }
        
        throw new EncodingException($this, 'Expected ValueUuid type or string');
    }
    
    public static function isUuid(mixed $value): bool
    {
        return is_string($value) && preg_match(self::PREG_UUID, $value);
    }
    
    protected function validateValue($value): bool
    {
        return parent::validateValue($value) && preg_match(self::PREG_UUID, $value);
    }
}