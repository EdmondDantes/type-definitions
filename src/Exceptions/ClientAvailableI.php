<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Exceptions;

/**
 * ## ClientAvailableInterface
 *
 * Exception can be shown to the client
 */
interface ClientAvailableI
{
    public function getClientMessage(): string;

    /**
     * Serialize exception for client
     */
    public function clientSerialize(): array;
}