<?php

namespace IfCastle\TypeDefinitions\Value;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\TypeUuid;
use Symfony\Component\Uid\Ulid;

class ValueUlid                     extends ValueContainer
{
    public static function create(): string
    {
        return (new Ulid)->toBase58();
    }

    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return new TypeUuid('guid');
    }
    
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}