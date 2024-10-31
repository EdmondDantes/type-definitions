<?php

declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Value;

interface ContainerUnserializableInterface
{
    /**
     * @var string
     */
    public const string TYPE_NODE = '@';

    /**
     * @var array<mixed> $data
     */
    public function containerUnserialize(array $data): mixed;
}
