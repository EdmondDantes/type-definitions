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
    protected array $arguments      = [];
    protected DefinitionInterface $returnType;
    
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
        return $this->arguments;
    }
    
    public function getReturnType(): DefinitionInterface
    {
        return $this->returnType;
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