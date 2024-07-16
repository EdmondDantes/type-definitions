<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\NativeSerialization;

interface EncodeDecodeInterface
{
    public function encode(mixed $data): mixed;
    
    public function decode(array|int|float|string|bool $data): mixed;
}