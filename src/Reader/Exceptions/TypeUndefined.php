<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader\Exceptions;

class TypeUndefined                 extends ReaderException
{
    protected string $template      = 'Type {source} is not defined. Mixed types cannot be used in type definitions.';
    
    public function __construct(string $source)
    {
        parent::__construct(['source' => $source]);
    }
}