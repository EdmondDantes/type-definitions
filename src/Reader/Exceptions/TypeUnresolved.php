<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader\Exceptions;

use IfCastle\TypeDefinitions\Resolver\TypeContextInterface;

class TypeUnresolved extends ReaderException
{
    protected string $template      = 'The {source} can\'t be resolved.';

    public function __construct(string $source = '', ?TypeContextInterface $typeContext = null)
    {
        /* @phpstan-ignore-next-line */
        if ($typeContext instanceof TypeContextInterface) {
            $sourceString           = match (true) {
                $typeContext->isReturnType()     => 'returnType',
                $typeContext->isProperty()       => 'property',
                $typeContext->isParameter()      => 'parameter'
            };

            if ($source !== '') {
                $sourceString       = ' "' . $source . '" ';
            }

            if ($typeContext->getClassName() !== null) {
                $sourceString       = ' of class ' . $typeContext->getClassName() . ' method ';
            }

            if ($typeContext->getFunctionName() !== null) {
                $sourceString       = $typeContext->getFunctionName();
            }

            $source                 = $sourceString;
        }

        parent::__construct(['source' => $source]);
    }
}
