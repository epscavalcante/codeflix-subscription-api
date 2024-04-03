<?php

namespace App\Repositories;

use App\Models\User as UserModel;
use App\Repositories\Mappers\UserEloquentRepositoryMapper;
use Core\Shared\Domain\Repositories\SearchResult;
use Core\Shared\Domain\Repositories\SearchResultInterface;
use Core\Shared\Domain\Uuid;
use Core\User\Domain\Exceptions\UserNotFoundException;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use Core\User\Domain\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly UserModel $model
    ) {
    }

    /**
     * @param User $entity
     */
    public function create(object $entity): void
    {
        $modelProps = UserEloquentRepositoryMapper::toModel((object) $entity);

        $this->model->create($modelProps->toArray());
    }

    /**
     * @param User $entity
     */
    public function update(object $user): void
    {
        $userModel = $this->model->find($user->getId());

        if (! $userModel) {
            throw new UserNotFoundException($user->getId());
        }

        $modelProps = UserEloquentRepositoryMapper::toModel((object) $user);

        $userModel->update($modelProps->toArray());
    }

    /**
     * @param Uuid $id
     */
    public function delete(object $id): void
    {
        $userModel = $this->model->find($id);

        if (! $userModel) {
            throw new UserNotFoundException($id);
        }

        $userModel->delete();
    }

    /**
     * @param  Uuid  $id
     */
    public function findById(object $id): ?User
    {
        $userModel = $this->model->find($id);

        if ($userModel) {
            return UserEloquentRepositoryMapper::toEntity($userModel);
        }

        return null;
    }

    public function search(
        ?string $filterBy = null,
        ?string $sortBy = 'name',
        ?string $sortDir = null,
        ?int $page = 1,
        ?int $perPage = 10,
    ): SearchResultInterface {

        $result = $this->model::query()
            //implements a filter using laravel scout
            ->orderBy($sortBy, $sortDir ?? 'DESC')
            ->paginate(
                perPage: $perPage,
                page: $page
            );

        return new SearchResult(
            items: array_map(fn ($userModel) => (UserEloquentRepositoryMapper::toEntity($userModel)), $result->items()),
            total: $result->total(),
            page: $result->currentPage(),
            perPage: $result->perPage(),
            previousPage: $result->currentPage() > 1
                ? $result->currentPage() - 1
                : null,
            nextPage: $result->currentPage() < $result->lastPage()
                ? $result->currentPage() + 1
                : null,
            firstPage: 1,
            lastPage: $result->lastPage()
        );
    }
}
