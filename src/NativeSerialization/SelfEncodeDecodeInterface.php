<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\NativeSerialization;

interface SelfEncodeDecodeInterface
{
    public function selfEncode(): mixed;
    
    public static function selfDecode(array|int|float|string|bool $data): static;
}