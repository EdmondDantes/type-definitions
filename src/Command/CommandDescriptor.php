<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Command;

use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\Exceptions\DescribeException;
use IfCastle\TypeDefinitions\TypeJson;
use IfCastle\TypeDefinitions\TypeObject;
use IfCastle\TypeDefinitions\TypeString;
use IfCastle\TypeDefinitions\Value\ValueObject;

class CommandDescriptor             extends ValueObject
                                    implements CommandDescriptorInterface
{
    /**
     * @throws DescribeException
     */
    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return (new TypeObject('command'))
            ->describe(new TypeString(self::SERVICE))
            ->describe(new TypeString(self::METHOD))
            ->describe(new TypeJson(self::PARAMETERS))
            ->setInstantiableClass(static::class)
            ->asReference()
            ->asImmutable();
    }

    #[\Override]
    public function getServiceNamespace(): string
    {
        return $this->value[self::SERVICE] ?? '';
    }

    #[\Override]
    public function getServiceName(): string
    {
        return $this->value[self::SERVICE] ?? '';
    }

    #[\Override]
    public function getMethodName(): string
    {
        return $this->value[self::METHOD] ?? '';
    }

    #[\Override]
    public function getCommandName(): string
    {
        return $this->getServiceName().'::'.$this->getMethodName();
    }

    #[\Override]
    public function getParameters(): array
    {
        return $this->value[self::PARAMETERS] ?? [];
    }
}