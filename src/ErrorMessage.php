<?php

namespace IfCastle\TypeDefinitions;

class ErrorMessage                  extends TypeObject
{
    public function __construct(string $name, DefinitionInterface ...$parameters)
    {
        parent::__construct($name);
        $this->describe(new TypeString('mui'));
        
        if($parameters !== []) {
            
            $object                 = new TypeObject('parameters');
            
            foreach ($parameters as $parameter) {
                $this->describe($parameter);
            }
            
            $this->describe($object);
        }
    }
}