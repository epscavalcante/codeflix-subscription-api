<?php

namespace Core\User\Domain\ValueObjects;

use Core\User\Domain\Exceptions\BirthdateInvalidException;
use DateTime;

class Birthdate
{
    public function __construct(
        private DateTime $value,
    ) {
        $this->validate();
    }

    public function getValue(): DateTime
    {
        return $this->value;
    }

    public function validate()
    {

        if (! checkdate(
            day: $this->getValue()->format('d'),
            month: $this->getValue()->format('m'),
            year: $this->getValue()->format('Y'),
        )) {
            throw new BirthdateInvalidException();
        }
    }

    public function __toString()
    {
        return $this->getValue()->format('Y-m-d');
    }

    public function getYearsOld(DateTime $sinceDate): int
    {
        $interval = $this->getValue()->diff($sinceDate);

        return (int) $interval->format('%Y');
    }
}
