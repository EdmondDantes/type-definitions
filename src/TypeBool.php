<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;

class TypeBool                      extends DefinitionAbstract
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::TYPE_BOOL, $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return $value === true || $value === false;
    }

    /**
     * @throws DefinitionIsNotValid
     */
    #[\Override]
    public function decode(array|int|float|string|bool $data): mixed
    {
        if(is_string($data)) {
            $data                   = strtolower($data);
        }

        return match ($data) {
            true, 1, 'true'         => true,
            false, 0, 'false'       => false,
            default                 => throw new DefinitionIsNotValid($this, 'Boolean type is invalid'),
        };
    }
    
    #[\Override]
    public function encode(mixed $data): mixed
    {
        // TODO: Implement encode() method.
        return $data;
    }
}