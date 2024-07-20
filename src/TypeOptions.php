<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\DefinitionIsNotValid;

/**
 * Select one from many with singe type
 * Compare: Enum: one of many types
 *
 */
class TypeOptions                   extends DefinitionAbstract
{
    public function __construct(string $name, protected DefinitionMutableInterface $option, protected array $variants, bool $isRequired = true, bool $isNullable = false)
    {
        parent::__construct($name, 'options', $isRequired, $isNullable);
        
        if($this->variants === []) {
            throw new DefinitionIsNotValid($this, 'Variants empty');
        }
    }
    
    #[\Override]
    public function isScalar(): bool
    {
        return true;
    }
    
    public function getVariants(): array
    {
        return $this->variants;
    }
    
    #[\Override]
    protected function validateValue(mixed $value): bool
    {
        return $this->option->validate($value, false) === null;
    }
    
    #[\Override]
    public function encode(mixed $data): mixed
    {
        return $data;
    }
    
    #[\Override]
    public function decode(mixed $data): mixed
    {
        return $this->option->decode($data);
    }
    
    #[\Override]
    protected function buildOpenApiSchema(callable $definitionHandler = null): array
    {
        return parent::buildOpenApiSchema($definitionHandler) + ['enum' => $this->variants];
    }
}