<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\NativeSerialization\ArraySerializableInterface;
use IfCastle\TypeDefinitions\NativeSerialization\EncodeDecodeInterface;

/**
 * ## Definition Interface
 *
 * a data structure that describes a **Type**.
 *
 * ## Used
 *
 * * Used to validate data structures, as well as to generate auto-documentation.
 * * It is the basis for building specifications of the Entity, describing the fields of the Database.
 * * Used to describe API request/response specification.
 * * Knows how to encode and decode data type from server to client and vice versa.
 */
interface DefinitionInterface               extends TypeInterface, EncodeDecodeInterface, ArraySerializableInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    public function getEncodeKey(): ?string;

    public function getDescription(): string;

    public function validate(mixed $value, bool $isThrow = true): ?\Throwable;

    public function toOpenApiSchema(callable $definitionHandler = null): array;
}