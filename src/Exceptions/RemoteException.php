<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Exceptions;

use IfCastle\Exceptions\BaseException;
use IfCastle\TypeDefinitions\DefinitionAwareInterface;
use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\DefinitionStaticAwareInterface;
use IfCastle\TypeDefinitions\TypeException;

final class RemoteException         extends BaseException
                                    implements DefinitionStaticAwareInterface, DefinitionAwareInterface
{
    public static function definition(): DefinitionMutableInterface
    {
        return (new TypeException('RemoteException'))
            ->setInstantiableClass(self::class)
            ->asReference()
            ->asImmutable();
    }
    
    public function getDefinition(): DefinitionInterface
    {
        return static::definition();
    }
}