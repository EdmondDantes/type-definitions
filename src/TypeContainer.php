<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DecodeException;
use IfCastle\TypeDefinitions\Exceptions\RemoteException;
use IfCastle\TypeDefinitions\NativeSerialization\DataEncoder;

/**
 * ## TypeContainer
 *
 * Object with information about type of data and data itself.
 * This container is used to transfer data between different systems when a type of data is unknown
 * or a type of data is variadic.
 *
 * We **don't recommend** using this container for **RPC calls between services**
 * because someone can use the wrong class name as a type of data, and it can be a security issue.
 *
 * TypeContainer is used in RPC calls between workers in the same node.
 *
 * ### Example
 * function foo(SomeInterface $data): void
 *
 */
class TypeContainer                 extends DefinitionAbstract
{
    public function isScalar(): bool
    {
        return false;
    }
    
    protected function validateValue($value): bool
    {
        return $value instanceof self;
    }
    
    public function encode(mixed $data): mixed
    {
        if ($data instanceof \Throwable && $data instanceof DefinitionStaticAwareInterface === false) {
            return [RemoteException::class, RemoteException::toArrayForRemote($data)];
        }
        
        return [get_class($data), DataEncoder::dataEncode($data)];
    }
    
    /**
     * @throws DecodeException
     */
    public function decode(mixed $data): mixed
    {
        if (is_object($data)) {
            return $data;
        }
        
        if (is_string($data)) {
            $data                   = $this->jsonDecode($data);
        }
        
        if (!is_array($data)) {
            throw new DecodeException($this, 'Expected array', ['value' => get_debug_type($data)]);
        }
        
        if (count($data) !== 2) {
            throw new DecodeException($this, 'Expected array with two elements');
        }
        
        [$type, $decodedData]       = $data;
        
        if (false === is_string($type)) {
            throw new DecodeException($this, 'Expected string as type', ['type' => get_debug_type($type)]);
        }
        
        if (false === class_exists($type)) {
            throw new DecodeException($this, 'Type class does not exist', ['type' => $type]);
        }
        
        if (false === is_subclass_of($type, DefinitionStaticAwareInterface::class)) {
            throw new DecodeException(
                $this,
                'Type class should be instance of DefinitionStaticAwareInterface',
                ['type' => $type]
            );
        }
        
        return $type::definition()->decode($decodedData);
    }
}