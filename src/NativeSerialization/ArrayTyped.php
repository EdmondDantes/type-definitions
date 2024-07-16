<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\NativeSerialization;

use IfCastle\TypeDefinitions\NativeSerialization\ArraySerializableInterface;
use IfCastle\TypeDefinitions\NativeSerialization\ArraySerializableValidatorInterface;
use Exceptions\LogicalException;
use Exceptions\UnSerializeException;

class ArrayTyped
{
    /**
     * special array-key for type information
     */
    final public const string TYPE         = '@';

    /**
     * @throws LogicalException
     */
    public static function serialize(ArraySerializableInterface $object, ArraySerializableValidatorInterface $validator = null): array
    {
        if($validator !== null && false === $validator->isSerializationAllowed($object)) {
            throw new LogicalException('Serialize not allowed for type '.$object::class);
        }

        return [self::TYPE => $object::class] + $object->toArray();
    }

    /**
     * @param    ArraySerializableValidatorInterface|null $validator
     * @param    ArraySerializableInterface[]             $objects
     *
     * @throws  LogicalException
     */
    public static function serializeList(ArraySerializableValidatorInterface $validator = null, ArraySerializableInterface ...$objects): array
    {
        $result                     = [];
        
        foreach ($objects as $object) {

            if($validator !== null && false === $validator->isSerializationAllowed($object)) {
                throw new LogicalException('Serialize not allowed for type '.$object::class);
            }

            $result[]               = [self::TYPE => $object::class] + $object->toArray();
        }
        
        return $result;
    }

    /**
     * @param    array|null                               $object
     * @param    ArraySerializableValidatorInterface|null $validator
     *
     * @return  mixed|null
     * @throws  UnSerializeException
     */
    public static function unserialize(array|null $object, ArraySerializableValidatorInterface $validator = null): mixed
    {
        if(false === array_key_exists(self::TYPE, $object)) {
            throw new UnSerializeException('Expected type node', self::class);
        }
    
        $class                  = $object[self::TYPE];

        if($validator !== null && false === $validator->isUnSerializationAllowed($class)) {
            throw new UnSerializeException('Unserialize not allowed for type '.$class, self::class);
        }

        if(false === class_exists($class)) {
            throw new UnSerializeException('Class '.$class.' not exists', self::class);
        }
    
        if(false === is_callable($class.'::fromArray')) {
            throw new UnSerializeException('Class '.$class.' not support ArraySerializableI', self::class);
        }
    
        return call_user_func($class.'::fromArray', $object);
    }

    /**
     * @param    array[]                                  $objects
     * @param    ArraySerializableValidatorInterface|null $validator
     *
     * @throws UnSerializeException
     */
    public static function unserializeList(array|null $objects, ArraySerializableValidatorInterface $validator = null): array|null
    {
        if($objects === null) {
            return null;
        }
        
        $result                     = [];
        
        foreach ($objects as $object) {
            
            if(!is_array($object)) {
                throw new UnSerializeException('Expected array, bug got '.get_debug_type($object), self::class);
            }
            
            $result[]               = self::unserialize($object, $validator);
        }
        
        return $result;
    }
}