<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Exceptions;

use IfCastle\Exceptions\BaseException;
use IfCastle\TypeDefinitions\DefinitionAwareInterface;
use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\DefinitionStaticAwareInterface;
use IfCastle\TypeDefinitions\TypeException;
use IfCastle\TypeDefinitions\Value\ContainerSerializableInterface;

final class RemoteException extends BaseException implements ContainerSerializableInterface, DefinitionStaticAwareInterface, DefinitionAwareInterface
{
    /**
     * @throws DescribeException
     */
    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return (new TypeException('RemoteException'))
            ->setInstantiableClass(self::class)
            ->asReference()
            ->asImmutable();
    }

    #[\Override]
    public function getDefinition(): DefinitionInterface
    {
        return self::definition();
    }

    #[\Override]
    public function containerSerialize(): array|string|bool|int|float|null
    {
        return $this->getDefinition()->encode($this);
    }

    /**
     * @throws EncodingException
     */
    #[\Override]
    public function containerToString(): string
    {
        try {
            return \json_encode($this->getDefinition()->encode($this), JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new EncodingException($this->getDefinition(), 'Failed to encode to JSON: ' . $exception->getMessage());
        }
    }
}
