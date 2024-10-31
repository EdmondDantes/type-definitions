<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Exceptions;

use IfCastle\Exceptions\ClientException;

class PreconditionFailed extends ClientException
{
    /**
     * PreconditionFailed constructor.
     *
     * @param string $reason
     * @param array<mixed> $debug
     */
    public function __construct(string $reason, array $debug = [])
    {
        parent::__construct('Precondition failed: {reason}', ['reason' => $reason]);

        $this->setDebugData($debug);
    }
}
