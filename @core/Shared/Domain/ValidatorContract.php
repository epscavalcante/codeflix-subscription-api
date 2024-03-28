<?php

namespace Core\Shared\Domain;

interface ValidatorContract
{
    public function validate(Notification $notification, array $data, array $fields): bool;
}
