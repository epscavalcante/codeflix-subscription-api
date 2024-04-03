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

        $this->validate();

        return $this;
    }

    public function changeDescription(string $description): self
    {
        $this->description = $description;

        $this->validate();

        return $this;
    }

    public function getId(): Uuid
    {
        return $this->planId;
    }

    public function validate(): void
    {
        $planValidator = PlanValidatorFactory::create();

        $planValidator->validate(
            entity: $this,
            rules: PlanRules::RULES
        );

        if ($this->notification->hasErrors()) {
            throw new PlanValidationException($this->notification->getErrors());
        }
    }

    public function toArray(): array
    {
        return [
            'planId' => $this->getId()->getValue(),
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
