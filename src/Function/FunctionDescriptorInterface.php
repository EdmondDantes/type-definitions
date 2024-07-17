<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Function;

use IfCastle\TypeDefinitions\TypeInterface;

interface FunctionDescriptorInterface
{
    public function getFunctionName(): string;
    
    public function getParametersDescriptor(): ParametersDescriptorInterface;
    
    public function getReturnType(): TypeInterface;
}