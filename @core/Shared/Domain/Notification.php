<?php

namespace Core\Shared\Domain;

class Notification
{
    /**
     * @var array<string, array>
     */
    private array $errors = [];

    public function addError(string $error, string $field)
    {
        if (count($this->errors) === 0) {
            $this->errors = [$field => [$error]];
        } else {
            if (array_key_exists($field, $this->errors)) {
                array_push($this->errors[$field], $error);
            } else {
                $this->errors[$field] = [$error];
            }
        }
    }

    /**
     * @return array<string, array>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }
}
