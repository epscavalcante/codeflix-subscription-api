<?php

namespace Core\User\Domain;

use Core\Shared\Domain\Entity;
use Core\Shared\Domain\Uuid;
use Core\User\Domain\Exceptions\UserValidationException;
use Core\User\Domain\Validators\UserRules;
use Core\User\Domain\Validators\UserValidatorFactory;
use Core\User\Domain\ValueObjects\Birthdate;
use Core\User\Domain\ValueObjects\Cpf;
use Core\User\Domain\ValueObjects\Email;
use Core\User\Domain\ValueObjects\Name;

class User extends Entity
{
    protected Uuid $userId;

    public function __construct(
        protected readonly Cpf $document,
        protected Name $name,
        protected Email $email,
        protected Birthdate $birthdate,
        ?string $userId = null
    ) {
        parent::__construct();
        $this->userId = $userId ? new Uuid($userId) : Uuid::create();
        $this->validate();
    }

    public function changeName(string $firstName, string $lastName): self
    {
        $this->name = new Name($firstName, $lastName);

        $this->validate();

        return $this;
    }

    public function changeEmail(string $email): self
    {
        $this->name = new Email($email);

        $this->validate();

        return $this;
    }

    public function getId(): Uuid
    {
        return $this->userId;
    }

    public function validate(): void
    {
        $userValidator = UserValidatorFactory::create();

        $userValidator->validate(
            entity: $this,
            rules: UserRules::RULES
        );

        if ($this->notification->hasErrors()) {
            throw new UserValidationException($this->notification->getErrors());
        }
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->getId()->getValue(),
            'document' => $this->document->getValue(),
            'name' => $this->name->getValue(),
            'email' => $this->email->getValue(),
            'birthdate' => $this->birthdate->getValue(),
        ];
    }
}
