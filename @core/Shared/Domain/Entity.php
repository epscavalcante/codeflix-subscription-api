<?php

namespace Core\Shared\Domain;

abstract class Entity
{
    protected Notification $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    abstract public function getId(): Uuid;

    abstract public function validate(): void;

    abstract public function toArray(): array;

    public function __get($field)
    {
        return $this->{$field};
    }
}
