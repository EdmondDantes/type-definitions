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
interface DefinitionInterface               extends EncodeDecodeInterface, ArraySerializableInterface
{
    /**
     * @var string
     */
    final public const string TYPE_NULL    = 'null';

    /**
     * @var string
     */
    final public const string TYPE_STRING  = 'string';

    /**
     * @var string
     */
    final public const string TYPE_NUMBER  = 'number';

    /**
     * @var string
     */
    final public const string TYPE_FLOAT   = 'float';

    /**
     * @var string
     */
    final public const string TYPE_BOOL    = 'bool';

    /**
     * @var string
     */
    final public const string TYPE_OBJECT  = 'object';

    /**
     * @var string
     */
    final public const string TYPE_LIST    = 'list';

    /**
     * @var string
     */
    final public const string TYPE_KEY_LIST    = 'key_list';

    /**
     * @var string
     */
    final public const string LIST_WITH_COMMA  = 'list_with_comma';

    /**
     * @var string
     */
    final public const string TYPE_ARRAY       = 'array';

    /**
     * @var string
     */
    final public const string TYPE_OPTIONS     = 'options';

    /**
     * @var string
     */
    final public const string TYPE_ENUM        = 'enum';

    /**
     * @var string
     */
    final public const string TYPE_DATE        = 'date';

    /**
     * @var string
     */
    final public const string TYPE_DATETIME    = 'datetime';

    /**
     * @var string
     */
    final public const string TYPE_TIME        = 'time';

    /**
     * @var string
     */
    final public const string TYPE_YEAR        = 'year';

    /**
     * @var string
     */
    final public const string TYPE_TIMESTAMP   = 'timestamp';

    /**
     * @var string
     */
    final public const string TYPE_UUID        = 'uuid';

    /**
     * @var string
     */
    final public const string TYPE_ULID        = 'ulid';

    /**
     * @var string
     */
    final public const string TYPE_MIXED       = 'mixed';

    public function getName(): string;

    public function getEncodeKey(): ?string;

    public function getType(): string;

    public function getDescription(): string;

    public function isRequired(): bool;

    public function isNullable(): bool;
    
    /**
     * Returns TRUE if a type is scalar: string, int, float, boolean, null
     */
    public function isScalar(): bool;

    public function canBySerializedFromString(): bool;
    
    /**
     * Returns TRUE if empty values like '' or 0 should be converted to NULL.
     */
    public function convertEmptyToNull(): bool;

    public function getReference(): string;

    public function getMinimum(): int|float|null;

    public function getMaximum(): int|float|null;

    public function getMaxLength(): ?int;

    public function getMinLength(): ?int;

    public function getPattern(): ?string;

    public function isEmptyToNull(): bool;

    public function validate(mixed $value, bool $isThrow = true): ?\Throwable;

    public function toOpenApiSchema(callable $definitionHandler = null): array;
}