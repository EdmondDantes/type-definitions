<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

class TypeBinary                    extends TypeString
{
    #[\Override]
    protected function toOpenApiFormat(): string
    {
        return 'binary';
    }
}