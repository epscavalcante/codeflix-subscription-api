<?php

namespace App\Repositories\Mappers;

use App\Models\User as UserModel;
use Core\Shared\Domain\Uuid;
use Core\User\Domain\User;
use Core\User\Domain\ValueObjects\Birthdate;
use Core\User\Domain\ValueObjects\Cpf;
use Core\User\Domain\ValueObjects\Email;
use Core\User\Domain\ValueObjects\Name;
use DateTime;

class UserEloquentRepositoryMapper
{
    public static function toModel(User $user): UserModel
    {
        $model = new UserModel();
        $model->user_id = $user->getId()->getValue();
        $model->document = $user->document->getValue();
        $model->first_name = $user->name->getFirstName();
        $model->last_name = $user->name->getLastName();
        $model->email = $user->email->getValue();
        $model->birthdate = $user->birthdate;

        return $model;
    }

    public static function toEntity(UserModel $model): User
    {
        return new User(
            userId: new Uuid($model->user_id),
            document: new Cpf($model->document),
            name: new Name($model->first_name, $model->last_name),
            email: new Email($model->email),
            birthdate: new Birthdate(
                new DateTime($model->birthdate)
            ),
        );
    }
}
