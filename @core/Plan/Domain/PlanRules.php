<?php

namespace Core\Plan\Domain;

class PlanRules
{
    private $rules = [
        'name' => ['required', 'string', 'max: 100'],
        'description' => ['required', 'string'],
    ];

    public function __construct(
        private readonly Plan $plan
    ) {
    }

    public function getData(?string $field = null): array
    {
        $properties = array_keys($this->rules);
        $data = [];

        foreach ($properties as $property) {
            $data[$property] = $this->plan->{$property};
        }

        if ($field && array_key_exists($field, $data)) {
            return [$field => $data[$field]];
        }

        return $data;
    }

    public function getRules(?string $field = null): array
    {
        if ($field && array_key_exists($field, $this->rules)) {
            return [$field => $this->rules[$field]];
        }

        return $this->rules;
    }
}
