<?php

namespace Core\Shared\Domain;

use Core\Shared\Domain\Exceptions\UuidInvalidException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        private string $value
    ) {
        $this->validate($value);
    }

    public static function create()
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function validate()
    {
        if (! RamseyUuid::isValid($this->value)) {
            throw new UuidInvalidException($this->value);
        }
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
