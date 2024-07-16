<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\NativeSerialization;

interface ArraySerializableInterface
{
    public function toArray(ArraySerializableValidatorInterface $validator = null): array;

    public static function fromArray(array $array, ArraySerializableValidatorInterface $validator = null): static;
}