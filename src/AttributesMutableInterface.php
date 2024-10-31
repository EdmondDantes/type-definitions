<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

interface AttributesMutableInterface extends AttributesInterface
{
    public function setAttributes(array $attributes): static;

    public function addAttributes(object ...$attributes): static;
}
