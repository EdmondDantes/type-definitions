<?php

namespace IfCastle\TypeDefinitions;

class Errors                        extends TypeOneOf
{
    protected array $errors;
    
    public function __construct(string $componentName, Error ...$errors)
    {
        parent::__construct($componentName);
        
        $this->errors               = $errors;
    }
    
    #[\Override]
    protected function defineEnumCases(): void
    {
        foreach ($this->errors as $error) {
            $class                  = $error->getErrorClassName();
            $this->describeCase(call_user_func($class.'::definitionByAttribute', $error));
        }
    }
}