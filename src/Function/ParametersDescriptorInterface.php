<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Function;

interface ParametersDescriptorInterface
{
    public function getParameters(): array;
}