<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(array $with = [], array $columns = ['*']): Collection
    {
        return $this->newQuery($with, $columns)->get();
    }

    public function paginate(int $perPage = 15, array $with = [], array $columns = ['*']): LengthAwarePaginator
    {
        return $this->newQuery($with, $columns)->paginate($perPage);
    }

    public function find(int|string $id, array $with = [], array $columns = ['*']): ?Model
    {
        return $this->newQuery($with, $columns)->find($id);
    }

    public function findOrFail(int|string $id, array $with = [], array $columns = ['*']): Model
    {
        return $this->newQuery($with, $columns)->findOrFail($id);
    }

    public function findByColumn(string $column, mixed $value, array $with = [], array $columns = ['*']): ?Model
    {
        return $this->newQuery($with, $columns)->where($column, $value)->first();
    }

    public function getByColumn(string $column, mixed $value, array $with = [], array $columns = ['*']): Collection
    {
        return $this->newQuery($with, $columns)->where($column, $value)->get();
    }

    public function create(array $attributes): Model
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function bulkCreate(array $rows): bool
    {
        return $this->model->newQuery()->insert($rows);
    }

    public function update(Model|int|string $model, array $attributes): Model
    {
        $model = $this->resolveModel($model);
        $model->fill($attributes)->save();

        return $model;
    }

    public function delete(Model|int|string $model): bool
    {
        return (bool) $this->resolveModel($model)->delete();
    }

    /**
     * Build a query with optional eager loads and column selection.
     *
     * @param  array<int, string>  $with
     * @param  array<int, string>  $columns
     */
    protected function newQuery(array $with = [], array $columns = ['*']): Builder
    {
        $query = $this->model->newQuery();

        if ($with !== []) {
            $query->with($with);
        }

        if ($columns !== ['*']) {
            $query->select($columns);
        }

        return $query;
    }

    /**
     * Accept either a hydrated model or a primary key and return the model.
     */
    protected function resolveModel(Model|int|string $model): Model
    {
        return $model instanceof Model ? $model : $this->findOrFail($model);
    }
}
