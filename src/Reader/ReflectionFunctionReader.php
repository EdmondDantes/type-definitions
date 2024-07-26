<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\Exceptions\BaseExceptionInterface;
use IfCastle\TypeDefinitions\DefinitionByErrorAbleInterface;
use IfCastle\TypeDefinitions\DefinitionInterface;
use IfCastle\TypeDefinitions\Error;
use IfCastle\TypeDefinitions\Exceptions\DefinitionBuilderException;
use IfCastle\TypeDefinitions\FunctionDescriptorInterface;
use IfCastle\TypeDefinitions\NativeSerialization\AttributeNameInterface;
use IfCastle\TypeDefinitions\Reader\Exceptions\TypeUnresolved;
use IfCastle\TypeDefinitions\Resolver\ResolverInterface;
use IfCastle\TypeDefinitions\Resolver\TypeContext;
use IfCastle\TypeDefinitions\Resolver\TypeContextInterface;
use IfCastle\TypeDefinitions\TypeErrorMessage;
use IfCastle\TypeDefinitions\TypeFunction;

class ReflectionFunctionReader      implements FunctionReaderInterface
{
    public function __construct(protected readonly ResolverInterface $resolver) {}
    
    public function extractFunctionDescriptor(string|\Closure $function): FunctionDescriptorInterface
    {
        $reflectedFunction          = new \ReflectionFunction($function);
        
        $functionDescriptor         = new TypeFunction($reflectedFunction->getName());
        
        foreach ($reflectedFunction->getParameters() as $parameter) {
            
            $typeContext            = new TypeContext(
                functionName:       $reflectedFunction->getName(),
                parameterName:      $parameter->getName(),
                attributes:         $this->extractAttributes($parameter),
                isParameter:        true
            );
            
            $typeReader             = $this->buildTypeReader($parameter, $typeContext);
            
            $definition             = $typeReader->generate();
            
            if($definition === null) {
                throw new TypeUnresolved($parameter->getName(), $typeContext);
            }
            
            $functionDescriptor->describe($definition);
        }
        
        $typeContext                = new TypeContext(
            functionName:           $reflectedFunction->getName(),
            attributes:             $this->extractAttributes($reflectedFunction),
            isReturnType:           true
        );
        
        $typeReader                 = $this->buildTypeReader($reflectedFunction->getReturnType(), $typeContext);
        
        $functionDescriptor->describeReturnType($typeReader->generate());
        $functionDescriptor->describePossibleErrors(...$this->buildPossibleErrors($reflectedFunction));
        
        return $functionDescriptor->asImmutable();
    }
    
    public function extractMethodDescriptor(string|object $object, string $method): FunctionDescriptorInterface
    {
        $reflectedMethod            = new \ReflectionMethod($object, $method);
        $reflectedClass             = $reflectedMethod->getDeclaringClass();
        
        $methodDescriptor           = new TypeFunction(
            name:       $reflectedMethod->getName(),
            className:  $reflectedClass->getName(),
            isStatic:   $reflectedMethod->isStatic()
        );
        
        foreach ($reflectedMethod->getParameters() as $parameter) {
            
            $typeContext            = new TypeContext(
                className:          $reflectedClass->getName(),
                functionName:       $reflectedMethod->getName(),
                parameterName:      $parameter->getName(),
                attributes:         $this->extractAttributes($parameter),
                isParameter:        true
            );
            
            $typeReader             = $this->buildTypeReader($parameter, $typeContext);
            
            $definition             = $typeReader->generate();
            
            if($definition === null) {
                throw new TypeUnresolved($parameter->getName(), $typeContext);
            }
            
            $methodDescriptor->describe($definition);
        }
        
        $typeContext                = new TypeContext(
            functionName:           $methodDescriptor->getName(),
            attributes:             $this->extractAttributes($reflectedMethod),
            isReturnType:           true
        );
        
        $typeReader                 = $this->buildTypeReader($reflectedMethod->getReturnType(), $typeContext);
        
        $methodDescriptor->describeReturnType($typeReader->generate());
        $methodDescriptor->describePossibleErrors(...$this->buildPossibleErrors($reflectedMethod));
        
        return $methodDescriptor->asImmutable();
    }
    
    protected function buildTypeReader(\ReflectionType|\ReflectionParameter|null $reflectionType, TypeContextInterface $typeContext): ReflectionTypeReader
    {
        return new ReflectionTypeReader($reflectionType, $typeContext, $this->resolver);
    }
    
    protected function extractAttributes(\Reflector $reflector): array
    {
        if(false === method_exists($reflector, 'getAttributes')) {
            return [];
        }
        
        $attributes                 = [];
        
        foreach ($reflector->getAttributes(AttributeNameInterface::class, \ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $attributes[]           = $attribute->newInstance();
        }

        return $attributes;
    }
    
    /**
     * Build possible errors from the method or function which are described by the Error attribute.
     *
     * @return DefinitionInterface[]
     * @throws DefinitionBuilderException
     */
    protected function buildPossibleErrors(\ReflectionMethod|\ReflectionFunction $method): array
    {
        $errors                     = [];

        $class                      = $method instanceof \ReflectionMethod ? $method->getDeclaringClass()->getName() : null;
        
        foreach ($method->getAttributes(Error::class, \ReflectionAttribute::IS_INSTANCEOF) as $attribute) {

            $error                  = $attribute->newInstance();

            if($error instanceof Error) {

                $errorClassName     = $error->errorClassName;

                if(is_subclass_of($errorClassName, DefinitionByErrorAbleInterface::class)) {
                    $definition     = call_user_func($errorClassName.'::definitionByError', $error);
                } else {
                    $definition     = $this->buildErrorDescriptorByExceptionClass($errorClassName);
                }

                if($definition instanceof DefinitionInterface === false) {
                    throw new DefinitionBuilderException([
                        'template'  => 'Incorrect definitionByAttribute returned type for {class} in the {class}->{method}. '
                            .'Must return type DefinitionI',
                        'errorClass'=> $errorClassName,
                        'class'     => $class,
                        'method'    => $method->getName()
                    ]);
                }

                $errors[]           = $definition;
            }
        }

        return $errors;
    }
    
    protected function buildErrorDescriptorByExceptionClass(string $errorClassName): DefinitionInterface
    {
        if(false === is_subclass_of($errorClassName, \Throwable::class)) {
            throw new DefinitionBuilderException([
                'template'  => 'Error class {class} must be a subclass of {parent}',
                'class'     => $errorClassName,
                'parent'    => \Throwable::class
            ]);
        }
        
        if(false === is_subclass_of($errorClassName, BaseExceptionInterface::class)) {
            return new TypeErrorMessage('internal error');
        }
        
        // Try to extract the template from the error class if possible
        $classReflection            = new \ReflectionClass($errorClassName);
        
        try {
            $template               = $classReflection->getProperty('template')->getDefaultValue();
        } catch (\ReflectionException) {
            return new TypeErrorMessage('internal error');
        }
        
        // Try to automatically extract the arguments from the error class if possible
        try {
            return new TypeErrorMessage($template, ...$this->extractMethodDescriptor($errorClassName, '__construct')->getArguments());
        } catch (\Throwable) {
            return new TypeErrorMessage($template);
        }
    }
}