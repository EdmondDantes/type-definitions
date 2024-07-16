<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

interface DefinitionMutableInterface        extends DefinitionInterface
{
    public function setName(string $name): static;

    public function setEncodeKey(string $encodeKey = null): static;
    
    public function setDescription(string $description): static;
    
    public function setIsRequired(bool $isRequired): static;
    
    public function setIsNullable(bool $isNullable): static;
    
    public function setEmptyToNull(bool $isEmptyToNull): static;
    
    public function setReference(string $reference): static;
    
    public function asReference(): static;
    
    public function setMinimum(int|float $minimum): static;
    
    public function setMaximum(int|float $maximum): static;
    
    public function setMaxLength(int $maxLength): static;
    
    public function setMinLength(int $minLength): static;
    
    public function setPattern(string $pattern): static;
    
    public function setIsEmptyToNull(bool $isEmptyToNull): static;

    /**
     * Mark object only for read
     * @return $this
     */
    public function asImmutable(): static;
}