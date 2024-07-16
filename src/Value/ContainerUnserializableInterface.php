<?php declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Value;

interface ContainerUnserializableInterface
{
    /**
     * @var string
     */
    public const TYPE_NODE                 = '@';

    public function containerUnserialize(array $data);
}