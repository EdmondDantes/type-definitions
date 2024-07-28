<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeYear                      extends TypeInteger
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        
        $this->type                 = 'year';
    }
}