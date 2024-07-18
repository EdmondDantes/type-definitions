<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Function;

use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\DefinitionMutableInterface;
use IfCastle\TypeDefinitions\Exceptions\DescribeException;
use IfCastle\TypeDefinitions\TypeInterface;
use IfCastle\TypeDefinitions\TypeJson;
use IfCastle\TypeDefinitions\TypeObject;
use IfCastle\TypeDefinitions\TypeString;
use IfCastle\TypeDefinitions\Value\ValueObject;

class FunctionDescriptor            extends ValueObject
                                    implements FunctionDescriptorInterface
{
    public const string FUNCTION    = 'function';
    public const string PARAMETERS  = 'parameters';
    public const string RETURN_TYPE = 'returnType';
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public static function definition(): DefinitionMutableInterface
    {
        return (new TypeObject('command'))
            ->describe(new TypeString(self::FUNCTION))
            ->describe(new TypeString(self::PARAMETERS))
            ->describe(new TypeJson(self::RETURN_TYPE))
            ->setInstantiableClass(static::class)
            ->asReference()
            ->asImmutable();
    }
    
    public function getFunctionName(): string
    {
        // TODO: Implement getFunctionName() method.
    }
    
    public function getParametersDescriptor(): ParametersDescriptorInterface
    {
        // TODO: Implement getParametersDescriptor() method.
    }
    
    public function getReturnType(): TypeInterface
    {
        // TODO: Implement getReturnType() method.
    }
}