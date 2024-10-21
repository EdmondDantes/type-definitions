<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeFunction                  extends TypeObject
                                    implements FunctionDescriptorInterface
{
    protected string $className     = '';
    protected string $functionName  = '';
    protected bool $isStatic        = false;
    protected string $scope         = '';
    protected DefinitionInterface $returnType;
    
    /**
     * array of return type errors
     *
     * @var DefinitionInterface[]
     */
    protected array $possibleErrors = [];
    
    public function __construct(
        string $name,
        string $className           = '',
        string $scope               = '',
        bool   $isStatic            = false,
        bool   $isRequired          = true,
        bool   $isNullable          = false
    )
    {
        parent::__construct(
            $name,
            $isRequired,
            $isNullable
        );
        
        $this->type                 = 'function';
        $this->functionName         = $name;
        $this->className            = $className;
        $this->isStatic             = $isStatic;
        $this->scope                = $scope;
    }
    
    public function getFunctionName(): string
    {
        return $this->functionName;
    }
    
    public function getClassName(): string
    {
        return $this->className;
    }
    
    public function getArguments(): array
    {
        return $this->properties;
    }
    
    public function getReturnType(): DefinitionInterface
    {
        return $this->returnType;
    }
    
    #[\Override]
    public function getPossibleErrors(): array
    {
        return $this->possibleErrors;
    }
    
    public function describeReturnType(DefinitionInterface $returnType): static
    {
        $this->returnType           = $returnType;
        
        return $this;
    }
    
    public function describePossibleErrors(DefinitionInterface ...$errors): static
    {
        $this->possibleErrors       = $errors;
        
        return $this;
    }
    
    public function getScope(): string
    {
        return $this->scope;
    }
    
    public function isInternal(): bool
    {
        return $this->scope === FunctionDescriptorInterface::SCOPE_INTERNAL;
    }
    
    public function isPublic(): bool
    {
        return $this->scope === FunctionDescriptorInterface::SCOPE_PUBLIC;
    }
    
    public function isClass(): bool
    {
        return $this->className !== '';
    }
    
    public function isStatic(): bool
    {
        return $this->isStatic;
    }
}