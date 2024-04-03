<?php

use App\Models\User as UserModel;
use App\Repositories\Mappers\UserEloquentRepositoryMapper;
use App\Repositories\UserEloquentRepository;
use Core\User\Domain\Exceptions\UserNotFoundException;
use Core\User\Domain\User;
use Core\User\Domain\Repositories\UserSearchResult;
use Core\Shared\Domain\Uuid;
use Core\User\Domain\ValueObjects\Birthdate;
use Core\User\Domain\ValueObjects\Cpf;
use Core\User\Domain\ValueObjects\Email;
use Core\User\Domain\ValueObjects\Name;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    /**
     * @var UserEloquentRepository $userRepository
     */
    $this->userRepository = new UserEloquentRepository(new UserModel());
});

describe('User Eloquent Repository', function () {
    test('Deve criar um plano', function () {
        $user = new User(
            document: new Cpf(fake('pt_BR')->cpf()),
            name: new Name('User', 'Test'),
            email: new Email('user.test@email.com'),
            birthdate: new Birthdate(
                new Datetime(
                    fake()->date()
                )
            )
        );

        $this->userRepository->create($user);

        expect(UserModel::count())->toBe(1);
        $UserModel = UserModel::first();
        expect($UserModel->user_id)->tobe($user->getId()->getValue());
        expect($UserModel->user_id)->tobe($user->getId()->getValue());
        expect($UserModel->user_id)->tobe($user->getId()->getValue());
    });

    describe('Find a User', function () {
        test('Deve retornar null ao buscar um user que não existe', function () {
            $userId = Uuid::create();
            $userFound = $this->userRepository->findById($userId);
            expect($userFound)->toBeNull();
        });

        test('Deve encontrar um User', function () {
            $UserModel = UserModel::factory()->create();
            $userId = new Uuid($UserModel->user_id);
            $userFound = $this->userRepository->findById($userId);

            expect($userFound)->toBeInstanceOf(User::class);
        });
    });

    describe('Delete a User', function () {
        test('Deve lançar UserNotFoundException ao excluir um plano que não existe', function () {
            $userId = Uuid::create();
            $this->userRepository->delete($userId);
        })->throws(UserNotFoundException::class);

        test('Deve encontrar um User', function () {
            $UserModel = UserModel::factory()->create();
            $userId = new Uuid($UserModel->user_id);
            $this->userRepository->delete($userId);

            expect(UserModel::count())->toBe(0);
            expect(UserModel::find($userId))->toBeNull();
        });
    });

    describe('Update a User', function () {
        test('Deve lançar UserNotFoundException ao atualizar um plano que não existe', function () {
            $user = new User(
                document: new Cpf(fake('pt_BR')->cpf()),
                name: new Name('User', 'Test'),
                email: new Email('user.test@email.com'),
                birthdate: new Birthdate(
                    new Datetime(
                        fake()->date()
                    )
                )
            );
            $this->userRepository->update($user);
        })->throws(UserNotFoundException::class);

        test('Deve atualizar um plano', function () {
            $UserModel = UserModel::factory()->create();
            $user = UserEloquentRepositoryMapper::toEntity($UserModel);
            $user->changeName('User ed', "Updated");
            $this->userRepository->update($user);

            $userUpdated = UserModel::find($user->getId());
            expect($userUpdated->user_id)->toBe($user->getId()->getValue());
            expect($userUpdated->first_name)->toBe('User ed');
            expect($userUpdated->last_name)->toBe('Updated');
        });
    });

    describe('List plans', function () {
        test('Deve retonar resultado padrão', function () {
            $result = $this->userRepository->search();

            expect($result)->toBeInstanceOf(UserSearchResult::class);
            expect($result->total())->toBe(0);
            expect($result->page())->toBe(1);
            expect($result->perPage())->toBe(10);
            expect($result->previousPage())->toBeNull();
            expect($result->nextPage())->toBeNull();
            expect($result->firstPage())->toBe(1);
            expect($result->lastPage())->toBe(1);
            expect($result->items())->toBeArray();
            expect($result->items())->toHaveCount(0);
        });

        test('Deve paginar e order os planos', function () {
            UserModel::factory()
                ->count(10)
                ->sequence(fn (Sequence $sequence) => ['first_name' => 'Name ' . $sequence->index])
                ->create();

            $result = $this->userRepository->search(
                sortBy: 'first_name',
                sortDir: 'ASC',
                page: 2,
                perPage: 5
            );

            expect($result)->toBeInstanceOf(UserSearchResult::class);
            expect($result->total())->toBe(10);
            expect($result->page())->toBe(2);
            expect($result->perPage())->toBe(5);
            expect($result->previousPage())->toBe(1);
            expect($result->nextPage())->toBeNull();
            expect($result->firstPage())->toBe(1);
            expect($result->lastPage())->toBe(2);
            expect($result->items())->toBeArray();
            expect($result->items())->toHaveCount(5);
        });
    });
});
