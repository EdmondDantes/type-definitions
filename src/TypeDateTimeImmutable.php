<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

use IfCastle\TypeDefinitions\Exceptions\EncodingException;

class TypeDateTimeImmutable     extends TypeDateTime
{
    /**
     * @throws EncodingException
     */
    #[\Override]
    public function encode(mixed $data): mixed
    {
        if(is_string($data) && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $data)) {
            return $data;
        }

        if($data instanceof \DateTimeImmutable === false) {
            throw new EncodingException($this, 'Expected type DateTimeImmutable');
        }

        return $data->format('Y-m-d H:i:s');
    }

    #[\Override]
    public function decode(float|array|bool|int|string $data): mixed
    {
        $date                   = parent::decode($data);

        return new \DateTimeImmutable($date);
    }
}