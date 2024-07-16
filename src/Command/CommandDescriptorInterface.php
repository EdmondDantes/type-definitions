<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Command;

/**
 * # Command Interface
 *
 * Main container for describe command
 */
interface CommandDescriptorInterface
{
    final public const string SERVICE      = 'service';
    
    final public const string METHOD       = 'method';
    
    final public const string PARAMETERS   = 'parameters';

    public function getServiceNamespace(): string;

    public function getServiceName(): string;
    
    public function getMethodName(): string;

    /**
     * Returns getServiceName + getMethodName
     */
    public function getCommandName(): string;
    
    public function getParameters(): array;
}