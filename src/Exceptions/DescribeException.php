<?php

namespace IfCastle\TypeDefinitions\Exceptions;

use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use Exceptions\LoggableException;


class DescribeException             extends LoggableException
{
    protected array $tags           = ['definition'];
    
    public function __construct(string $message, DefinitionMutableInterface $definition, array $exData = [])
    {
        parent::__construct([
            'message'               => $message,
            'definition'            => $definition->getName(),
            'class'                 => $definition::class
        ] + $exData);
    }
}