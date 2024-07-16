<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeTimestamp                 extends TypeNumber
{
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, $isRequired, $isNullable);
        
        $this->type                 = self::TYPE_TIMESTAMP;
    }
}