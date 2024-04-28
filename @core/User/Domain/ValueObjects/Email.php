<?php

namespace Core\User\Domain\ValueObjects;

use Core\User\Domain\Exceptions\EmailInvalidException;

class Email
{
    public function __construct(
        private string $value,
    ) {
        $this->validate();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function validate()
    {
        if (! filter_var($this->getValue(), FILTER_VALIDATE_EMAIL)) {
            throw new EmailInvalidException();
        }
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
