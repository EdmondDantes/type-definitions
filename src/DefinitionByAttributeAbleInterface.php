<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

interface DefinitionByAttributeAbleInterface
{
    public static function definitionByAttribute(Error $error): DefinitionInterface;
}