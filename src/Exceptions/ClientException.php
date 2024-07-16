<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Exceptions;

use IfCastle\TypeDefinitions\DefinitionByAttributeAbleInterface;
use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\Error;
use IfCastle\TypeDefinitions\ErrorMessage;
use Exceptions\BaseException;

/**
 * A special class of error that can be displayed to the client
 */
class ClientException               extends     BaseException
                                    implements ClientAvailableI, DefinitionByAttributeAbleInterface
{
    #[\Override]
    public static function definitionByAttribute(Error $error): DefinitionInterface
    {
        $errorMessage               = new ErrorMessage($error->template, ...$error->parameters);
        $errorMessage->setDescription($error->description);
        
        return $errorMessage;
    }
    
    public function __construct(string $template, array $parameters = [], array $debugData = [])
    {
        parent::__construct(['template' => $template] + $parameters);
        $this->setDebugData($debugData);
    }
    
    #[\Override]
    public function getClientMessage(): string
    {
        return $this->template !== '' ? $this->template : $this->getMessage();
    }

    #[\Override]
    public function clientSerialize(): array
    {
        return [
            'template'              => $this->template,
            'message'               => $this->getMessage(),
            'parameters'            => $this->getExceptionData()
        ];
    }
}