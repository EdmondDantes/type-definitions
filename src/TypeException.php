<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DescribeException;

/**
 * Class TypeException.
 *
 * @package IfCastle\TypeDefinitions
 */
class TypeException extends TypeObject
{
    /**
     * @throws DescribeException
     */
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct(
            $name,
            $isRequired,
            $isNullable
        );

        $this->type                     = 'exception';

        $this->describe((new TypeString('message'))->setDescription('The error message.'))
                ->describe((new TypeString('code'))->setDescription('The error code.'))
                ->describe((new TypeString('file'))->setDescription('The file in which the error occurred.'))
                ->describe((new TypeInteger('line'))->setDescription('The line number on which the error occurred.'))
                ->describe((new TypeJson('trace'))->setDescription('The stack trace of the error.'))
                ->describe((new TypeString('class'))->setDescription('The class of exception.'))
                ->describe((new TypeString('template', isRequired: false, isNullable: true))
                               ->setDescription('The template of exception.'))
                ->describe((new TypeList('tags', new TypeString('tag'), isRequired: false, isNullable: true))
                               ->setDescription('The tags of the exception.'))
                ->describe((new TypeJson('data', isRequired: false, isNullable: true))
                               ->setDescription('The data of the exception.'))
                ->describe((new TypeSelf('previous'))->setDescription('The previous exception.'));
    }
}
