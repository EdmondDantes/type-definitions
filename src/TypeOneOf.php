<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;
use IfCastle\TypeDefinitions\Exceptions\DescribeException;

class TypeOneOf                     extends DefinitionAbstract
{
    /**
     * @var DefinitionInterface[]
     */
    protected array $cases          = [];
    
    public function __construct(string $name, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, self::TYPE_ENUM, $isRequired, $isNullable);
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        foreach ($this->cases as $enumCase) {
            if(false === $enumCase->isScalar()) {
                return false;
            }
        }
        
        return true;
    }
    
    public function describeCase(DefinitionInterface $definition): static
    {
        if(array_key_exists($definition->getName(), $this->cases)) {
            throw new DescribeException(sprintf('Case \'%s\' already exists ', $definition->getName()), $this);
        }
        
        $this->cases[$definition->getName()] = $definition;
        
        return $this;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        if($this->cases === []) {
            throw new DefinitionIsNotValid($this, 'Enum types should be not empty');
        }
        
        foreach ($this->cases as $type) {
            if($type->validate($value, false) === null) {
                return true;
            }
        }
        
        return false;
    }
    
    protected function defineEnumCases(): void
    {
    }
    
    public function getCases(): array
    {
        if($this->cases === []) {
            $this->defineEnumCases();
        }
        
        return $this->cases;
    }

    #[\Override]
    public function encode(mixed $data): mixed
    {
        // TODO: Implement arrayEncode() method.
    }

    /**
     * @throws DefinitionIsNotValid
     */
    #[\Override]
    public function decode(array|int|float|string|bool $data): mixed
    {
        if($this->cases === []) {
            throw new DefinitionIsNotValid($this, 'Enum types should be not empty');
        }
        
        foreach ($this->cases as $type) {
            try {
                $decodedValue            = $type->decode($data);
                
                if($type->validate($decodedValue, false) === null) {
                    return $decodedValue;
                }
                
            } catch (DefinitionIsNotValid) {
                continue;
            }
        }
    
        throw new DefinitionIsNotValid($this, 'Enum types are not matched');
    }
    
    #[\Override]
    protected function buildOpenApiSchema(callable $definitionHandler = null): array
    {
        $array                      = [];
        
        foreach ($this->cases as $enumCase) {
            $array[]                = $enumCase->toOpenApiSchema($definitionHandler);
        }
        
        return ['oneOf' => $array];
    }
}