<?php

namespace Core\User\Domain\ValueObjects;

use Core\User\Domain\Exceptions\CpfInvalidException;

class Cpf
{
    private string $cpf;

    const LENGTH_CHARACTERS = 11;

    public function __construct(
        string $value,
    ) {
        $this->cpf = $this->cleanValue($value);
        $this->validate();
    }

    public function getValue(): string
    {
        return $this->cpf;
    }

    public function validate()
    {
        $cpf = $this->getValue();

        if (
            ! $this->lengthIsValid($cpf) ||
            ! $this->theSequenceIsValid($cpf) ||
            $this->digitsAreTheSame($cpf)
        ) {
            throw new CpfInvalidException();
        }
    }

    public function __toString()
    {
        return $this->getValue();
    }

    private function cleanValue($cpf): string
    {
        return preg_replace('/[^0-9]/is', '', $cpf);
    }

    private function lengthIsValid($cpf): bool
    {
        $result = strlen($cpf) === self::LENGTH_CHARACTERS;

        return $result;
    }

    private function digitsAreTheSame($cpf): bool
    {
        $result = boolval(preg_match('/(\d)\1{10}/', $cpf));

        return $result;
    }

    private function theSequenceIsValid($cpf)
    {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
