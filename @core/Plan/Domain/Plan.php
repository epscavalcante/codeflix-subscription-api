<?php

namespace Core\Plan\Domain;

use Core\Plan\Domain\Exceptions\PlanValidationException;
use Core\Shared\Domain\Entity;
use Core\Shared\Domain\Uuid;

class Plan extends Entity
{
    protected Uuid $planId;

    public function __construct(
        protected string $name,
        protected string $description,
        ?string $planId = null
    ) {
        parent::__construct();
        $this->planId = $planId ? new Uuid($planId) : Uuid::create();
        $this->validate();
    }

    public function changeName(string $name): self
    {
        $this->name = $name;

        $this->validate('name');

        return $this;
    }

    public function changeDescription(string $description): self
    {
        $this->description = $description;

        $this->validate('description');

        return $this;
    }

    public function getId(): Uuid
    {
        return $this->planId;
    }

    public function validate(?string $field = null): bool
    {
        $planValidator = PlanValidatorFactory::create();
        $planRules = new PlanRules($this);
        $data = $planRules->getData($field);
        $rules = $planRules->getRules($field);

        $planValidator->validate(
            notification: $this->notification,
            data: $data,
            rules: $rules,
        );

        if ($this->notification->hasErrors()) {
            throw new PlanValidationException($this->notification->getErrors());
        }

        return ! $this->notification->hasErrors();
    }

    public function toArray(): array
    {
        return [
            'planId' => $this->getId(),
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
