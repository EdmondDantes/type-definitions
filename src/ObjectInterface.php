<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\NativeSerialization\ArraySerializableInterface;

interface ObjectInterface extends DefinitionInterface, ArraySerializableInterface
{
    public function getProperties(): array;
}