<?php

namespace Core\User\Domain\ValueObjects;

use Core\User\Domain\Exceptions\NameInvalidException;

class Name
{
    const NAME_MAX_LENGTH = 255;

    const NAME_MIN_LENGTH = 3;

    private string $firstName;

    private string $lastName;

    public function __construct(
        string $firstName,
        string $lastName
    ) {
        $this->firstName = $this->cleanValue($firstName);
        $this->lastName = $this->cleanValue($lastName);
        $this->validate();
    }

    public function validate()
    {
        if (
            ! $this->lengthIsValid($this->firstName) ||
            ! $this->lengthIsValid($this->lastName)
        ) {
            throw new NameInvalidException();
        }

        if (strlen($this->getValue()) > self::NAME_MAX_LENGTH) {
            throw new NameInvalidException();
        }
    }

    private function lengthIsValid($value): bool
    {
        $length = strlen($value);

        return $length > self::NAME_MIN_LENGTH && $length <= self::NAME_MAX_LENGTH;
    }

    public function cleanValue($value)
    {
        return trim($value);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getValue(): string
    {
        return $this->getFullName();
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
