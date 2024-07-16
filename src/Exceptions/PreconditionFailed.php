<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Exceptions;

class PreconditionFailed            extends ClientException
{
    public function __construct(string $reason, array $debug = [])
    {
        parent::__construct('Precondition failed: {reason}', ['reason' => $reason]);
        
        $this->setDebugData($debug);
    }
}