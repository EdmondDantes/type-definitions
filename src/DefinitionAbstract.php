<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\NativeSerialization\ArraySerializableValidatorInterface;
use IfCastle\TypeDefinitions\Exceptions\DecodeException;
use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;
use IfCastle\TypeDefinitions\Exceptions\DescribeException;
use IfCastle\TypeDefinitions\Exceptions\ParseException;

abstract class DefinitionAbstract   implements DefinitionMutableInterface
{
    public static function getDefinitionByNativeType(string $name, mixed $value): ?DefinitionMutableInterface
    {
        return match (true) {
            $value === null         => new TypeNull($name),
            is_bool($value)         => new TypeBool($name),
            is_string($value)       => new TypeString($name),
            is_int($value)          => new TypeInteger($name),
            is_float($value)        => new TypeFloat($name),
            is_array($value)        => new TypeJson($name),
            default                 => null,
        };
    }

    /**
     * @throws ParseException
     */
    public static function jsonToArray(mixed $value): array
    {
        try {
            if(is_string($value)) {
                $value              = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            }
        } catch (\JsonException $jsonException) {
            throw new ParseException('Value must be a valid JSON string', 0, $jsonException);
        }

        if(!is_array($value)) {
            throw new ParseException([
                'template'          => 'Value must be an array, got {type} instead.',
                'type'              => get_debug_type($value),
            ]);
        }

        return $value;
    }
    
    protected ?string $encodeKey    = null;
    
    protected bool $isEmptyToNull   = false;
    
    protected string $description   = '';

    /**
     * The name of the class that can instantiate an object from the raw-data
     */
    protected string $instantiableClass = '';
    
    /**
     * Used for OpenAPI reference
     */
    protected string $reference     = '';
    
    private bool $isImmutable       = false;

    public function __construct(protected string $name, protected string $type, protected bool $isRequired = true, protected bool $isNullable = false)
    {
    }
    
    public function __clone(): void
    {
        $this->isImmutable          = false;
    }
    
    #[\Override]
    public function getName(): string
    {
        return $this->name;
    }
    
    #[\Override]
    public function setName(string $name): static
    {
        $this->throwIfImmutable();
        $this->name                 = $name;
        return $this;
    }

    #[\Override]
    public function getEncodeKey(): ?string
    {
        return $this->encodeKey;
    }

    #[\Override]
    public function setEncodeKey(string $encodeKey = null): static
    {
        $this->throwIfImmutable();
        $this->encodeKey            = $encodeKey;
        return $this;
    }

    #[\Override]
    public function getTypeName(): string
    {
        return $this->type;
    }
    
    #[\Override]
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     *
     * @return $this
     * @throws DescribeException
     */
    #[\Override]
    public function setIsRequired(bool $isRequired): static
    {
        $this->throwIfImmutable();
        $this->isRequired           = $isRequired;
        return $this;
    }
    
    #[\Override]
    public function isNullable(): bool
    {
        return $this->isNullable;
    }
    
    /**
     * @return $this
     */
    #[\Override]
    public function setIsNullable(bool $isNullable): static
    {
        $this->throwIfImmutable();
        $this->isNullable           = $isNullable;
        
        return $this;
    }

    #[\Override]
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     *
     * @return $this
     * @throws DescribeException
     */
    #[\Override]
    public function setDescription(string $description): static
    {
        $this->throwIfImmutable();
        $this->description          = $description;
        
        return $this;
    }
    
    #[\Override]
    public function convertEmptyToNull(): bool
    {
        return $this->isEmptyToNull;
    }
    
    /**
     *
     * @return $this
     * @throws DescribeException
     */
    #[\Override]
    public function setEmptyToNull(bool $isEmptyToNull): static
    {
        $this->throwIfImmutable();
        $this->isEmptyToNull        = $isEmptyToNull;
        
        return $this;
    }
    
    #[\Override]
    public function getReference(): string
    {
        return $this->reference;
    }
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public function setReference(string $reference): static
    {
        $this->throwIfImmutable();
        $this->reference            = $reference;
        
        return $this;
    }
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public function asReference(): static
    {
        $this->throwIfImmutable();
        return $this->setReference('#/components/schemas/'.$this->getName());
    }
    
    #[\Override]
    public function getMinimum(): float|int|null
    {
        return $this->minimum;
    }
    
    /**
     * @param float|int $minimum
     *
     * @throws DescribeException
     */
    #[\Override]
    public function setMinimum(float|int $minimum): static
    {
        $this->throwIfImmutable();
        $this->minimum              = $minimum;
        return $this;
    }
    
    #[\Override]
    public function getMaximum(): float|int|null
    {
        return $this->maximum;
    }
    
    /**
     * @param float|int $maximum
     *
     * @throws DescribeException
     */
    #[\Override]
    public function setMaximum(float|int $maximum): static
    {
        $this->throwIfImmutable();
        $this->maximum              = $maximum;
        return $this;
    }
    
    #[\Override]
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public function setMaxLength(int $maxLength): static
    {
        $this->throwIfImmutable();
        $this->maxLength            = $maxLength;
        return $this;
    }
    
    #[\Override]
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public function setMinLength(int $minLength): static
    {
        $this->throwIfImmutable();
        $this->minLength            = $minLength;
        return $this;
    }
    
    #[\Override]
    public function getPattern(): ?string
    {
        return $this->pattern;
    }
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public function setPattern(string $pattern): static
    {
        $this->throwIfImmutable();
        $this->pattern              = $pattern;
        return $this;
    }
    
    #[\Override]
    public function isEmptyToNull(): bool
    {
        return $this->isEmptyToNull;
    }
    
    /**
     * @throws DescribeException
     */
    #[\Override]
    public function setIsEmptyToNull(bool $isEmptyToNull): static
    {
        $this->throwIfImmutable();
        $this->isEmptyToNull        = $isEmptyToNull;
        return $this;
    }
    
    public function getInstantiableClass(): string
    {
        return $this->instantiableClass;
    }
    
    /**
     * @throws DescribeException
     */
    public function setInstantiableClass(string $instantiableClass): static
    {
        $this->throwIfImmutable();
        $this->instantiableClass    = $instantiableClass;
        return $this;
    }

    /**
     * Method that validates the parameter
     *
     * @param    mixed    $value
     * @param    bool     $isThrow
     *
     * @return \Throwable|null
     * @throws DefinitionIsNotValid
     */
    #[\Override]
    public function validate(mixed $value, bool $isThrow = true): ?\Throwable
    {
        $error                      = null;
        
        if(($this->isNullable || !$this->isRequired) && $value === null) {
            return null;
        }
        
        // Convert empty string as NULL
        if($this->isEmptyToNull && $value === '')
        {
            $value                  = null;
        }
        
        if ($this->isRequired && !$this->isNullable && $value === null) {
            $error                  = new DefinitionIsNotValid($this, sprintf('Definition \'%s\' cannot be NULL', $this->name));
        } elseif ($value !== null && false === $this->validateValue($value)) {
            $error                  = new DefinitionIsNotValid($this, $this->getErrorMessageForValidate($value));
        }
        
        if($error === null) {
            return null;
        }
        
        if($isThrow) {
            throw $error;
        }
        
        return $error;
    }

    #[\Override]
    public function asImmutable(): static
    {
        $this->isImmutable          = true;
        return $this;
    }

    abstract protected function validateValue(mixed $value): bool;
    
    protected function getErrorMessageForValidate($value): string
    {
        return sprintf('Definition \'%s\' does not match type \'%s\'', $this->name, $this->type);
    }
    
    /**
     * @throws DecodeException
     */
    protected function jsonDecode(string $value): array
    {
        $result                     = json_decode($value, true);
        
        if(!is_array($result)) {
            throw new DecodeException($this, 'value is not a json: '.json_last_error_msg(), ['value' => $value]);
        }
        
        return $result;
    }
    
    #[\Override]
    public function toArray(ArraySerializableValidatorInterface $validator = null): array
    {
        return
        [
            'name'                  => $this->name,
            'type'                  => $this->type,
            'is_required'           => $this->isRequired,
            'is_nullable'           => $this->isNullable,
            'description'           => $this->description
        ];
    }

    #[\Override]
    public static function fromArray(array $array, ArraySerializableValidatorInterface $validator = null): static
    {
        // TODO fromArray
    }

    #[\Override]
    public function toOpenApiSchema(callable $definitionHandler = null): array
    {
        if($this->reference !== '' && $definitionHandler !== null) {
            
            $definitionHandler($this);
            
            return [
                '$ref'              => $this->reference,
            ];
        }

        return $this->buildOpenApiSchema($definitionHandler);
    }
    
    protected function buildOpenApiSchema(callable $definitionHandler = null): array
    {
        $array                      = [];
    
        if($this->name !== '' && $this->name !== '0') {
            $array['title']         = $this->name;
        }
    
        $array['type']              = $this->toOpenApiType();
        $array['format']            = $this->toOpenApiFormat();
    
        if(empty($array['format'])) {
            unset($array['format']);
        }
    
        if($this->isNullable) {
            $array['nullable']      = true;
        }
    
        if($this->minimum !== null) {
            $array['minimum']       = $this->minimum;
        }
    
        if($this->maximum !== null) {
            $array['maximum']       = $this->maximum;
        }
    
        if($this->minLength !== null) {
            $array['minLength']     = $this->minLength;
        }
    
        if($this->maxLength !== null) {
            $array['maxLength']     = $this->maxLength;
        }
    
        if($this->ecmaPattern !== null) {
            $array['pattern']       = $this->ecmaPattern;
        }
        
        return $array;
    }
    
    protected function toOpenApiType(): string
    {
        return match ($this->type) {
            self::TYPE_NULL         => 'null',
            self::TYPE_BOOL         => 'boolean',
            self::TYPE_TIMESTAMP,
            self::TYPE_NUMBER       => 'integer',
            self::TYPE_FLOAT        => 'number',
            self::TYPE_OBJECT, self::TYPE_KEY_LIST
                                    => 'object',
            self::TYPE_ARRAY, self::TYPE_LIST
                                    => 'array',
            default                 => 'string'
        };
    }
    
    protected function toOpenApiFormat(): string
    {
        return match ($this->type) {
            self::TYPE_NUMBER       => 'int32',
            self::TYPE_TIMESTAMP    => 'timestamp',
            self::TYPE_FLOAT        => 'float',
            
            self::TYPE_DATE         => 'date',
            self::TYPE_TIME         => 'time',
            self::TYPE_UUID         => 'guid',
            
            default                 => ''
        };
    }

    /**
     * @throws DescribeException
     */
    protected function throwIfImmutable(): void
    {
        if($this->isImmutable) {
            throw new DescribeException('definition is immutable', $this);
        }
    }
}