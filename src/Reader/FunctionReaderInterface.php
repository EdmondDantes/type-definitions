<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\FunctionDescriptorInterface;

interface FunctionReaderInterface
{
    public function extractFunctionDescriptor(string|\Closure $function): FunctionDescriptorInterface;
    
    public function extractMethodDescriptor(string $class, string $method): FunctionDescriptorInterface;
}