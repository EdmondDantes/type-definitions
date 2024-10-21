<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Reader;

use IfCastle\TypeDefinitions\Error;
use IfCastle\TypeDefinitions\Resolver\ExplicitTypeResolver;
use IfCastle\TypeDefinitions\TypeErrorMessage;
use IfCastle\TypeDefinitions\TypeFunction;
use IfCastle\TypeDefinitions\TypeVoid;
use PHPUnit\Framework\TestCase;

class ReflectionFunctionReaderTest  extends TestCase
{
    public function testExtractFunctionDescriptor(): void
    {
        $function = function (int $integer, float $float, bool $boolean, array $array, string $string): void {};
        
        $reflectionFunctionReader = new ReflectionFunctionReader(new ExplicitTypeResolver);
        
        $definition = $reflectionFunctionReader->extractFunctionDescriptor($function);
        
        $this->assertNotNull($definition, 'Definition is null');
        $this->assertEquals(__NAMESPACE__.'\\{closure}', $definition->getName());
        $this->assertInstanceOf(TypeFunction::class, $definition);
        
        foreach ($definition->getArguments() as $argument) {
            
            $this->assertNotNull($argument, 'Argument is null');
            
            switch ($argument->getName()) {
                case 'integer':
                    $this->assertEquals('integer', $argument->getTypeName());
                    break;
                case 'float':
                    $this->assertEquals('float', $argument->getTypeName());
                    break;
                case 'boolean':
                    $this->assertEquals('bool', $argument->getTypeName());
                    break;
                case 'array':
                    $this->assertEquals('array', $argument->getTypeName());
                    break;
                case 'string':
                    $this->assertEquals('string', $argument->getTypeName());
                    break;
                default:
                    $this->fail('Unknown argument type');
            }
        }
        
        $this->assertNotNull($definition->getReturnType(), 'Return type is null');
        $this->assertInstanceOf(TypeVoid::class, $definition->getReturnType());
    }
    
    public function testExtractMethodDescriptor(): void
    {
        $class = new class {
            #[Error('Error message', 'This is an error')]
            #[SomeAttribute]
            public function test(int $integer, float $float, bool $boolean, array $array, string $string): void {}
        };
        
        $reflectionFunctionReader = new ReflectionFunctionReader(new ExplicitTypeResolver);
        
        $definition = $reflectionFunctionReader->extractMethodDescriptor($class, 'test');
        
        $this->assertNotNull($definition, 'Definition is null');
        $this->assertEquals('test', $definition->getName());
        $this->assertInstanceOf(TypeFunction::class, $definition);
        $this->assertEquals($class::class, $definition->getClassName());
        
        foreach ($definition->getArguments() as $argument) {
            
            $this->assertNotNull($argument, 'Argument is null');
            
            switch ($argument->getName()) {
                case 'integer':
                    $this->assertEquals('integer', $argument->getTypeName());
                    break;
                case 'float':
                    $this->assertEquals('float', $argument->getTypeName());
                    break;
                case 'boolean':
                    $this->assertEquals('bool', $argument->getTypeName());
                    break;
                case 'array':
                    $this->assertEquals('array', $argument->getTypeName());
                    break;
                case 'string':
                    $this->assertEquals('string', $argument->getTypeName());
                    break;
                default:
                    $this->fail('Unknown argument type');
            }
        }
        
        $this->assertNotNull($definition->getReturnType(), 'Return type is null');
        $this->assertInstanceOf(TypeVoid::class, $definition->getReturnType());
        
        $this->assertNotEmpty($definition->getPossibleErrors(), 'Possible errors is empty');
        $this->assertCount(1, $definition->getPossibleErrors(), 'Possible errors count is not 1');
        
        $possibleError = $definition->getPossibleErrors()[0];
        
        $this->assertInstanceOf(TypeErrorMessage::class, $possibleError);
        
        if($possibleError instanceof TypeErrorMessage) {
            $this->assertEquals('Error message', $possibleError->getName());
            $this->assertEquals('This is an error', $possibleError->getDescription());
        }
        
        $this->assertNotEmpty($definition->getAttributes(), 'Attributes is empty');
        $this->assertCount(2, $definition->getAttributes(), 'Attributes count is not 1');
        
        $attribute = $definition->getAttributes()[1] ?? null;
        
        $this->assertInstanceOf(SomeAttribute::class, $attribute);
    }
}
