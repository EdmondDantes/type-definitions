<?php

namespace IfCastle\TypeDefinitions\Exceptions;

use IfCastle\Exceptions\LoggableException;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;


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