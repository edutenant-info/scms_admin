<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get a fresh query builder for the underlying model.
     */
    public function query(): Builder;

    /**
     * Fetch all records.
     *
     * @param  array<int, string>  $with     Relations to eager load.
     * @param  array<int, string>  $columns  Columns to select.
     * @return Collection<int, Model>
     */
    public function all(array $with = [], array $columns = ['*']): Collection;

    /**
     * Paginate records.
     *
     * @param  array<int, string>  $with
     * @param  array<int, string>  $columns
     */
    public function paginate(int $perPage = 15, array $with = [], array $columns = ['*']): LengthAwarePaginator;

    /**
     * Find a record by its primary key.
     *
     * @param  array<int, string>  $with
     * @param  array<int, string>  $columns
     */
    public function find(int|string $id, array $with = [], array $columns = ['*']): ?Model;

    /**
     * Find a record by its primary key or throw a ModelNotFoundException.
     *
     * @param  array<int, string>  $with
     * @param  array<int, string>  $columns
     */
    public function findOrFail(int|string $id, array $with = [], array $columns = ['*']): Model;

    /**
     * Fetch the first record matching a column value.
     *
     * @param  array<int, string>  $with
     * @param  array<int, string>  $columns
     */
    public function findByColumn(string $column, mixed $value, array $with = [], array $columns = ['*']): ?Model;

    /**
     * Fetch all records matching a column value.
     *
     * @param  array<int, string>  $with
     * @param  array<int, string>  $columns
     * @return Collection<int, Model>
     */
    public function getByColumn(string $column, mixed $value, array $with = [], array $columns = ['*']): Collection;

    /**
     * Create a record.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Model;

    /**
     * Insert many rows in a single statement (no model events / timestamps).
     *
     * @param  array<int, array<string, mixed>>  $rows
     */
    public function bulkCreate(array $rows): bool;

    /**
     * Update a record (accepts a model instance or a primary key).
     *
     * @param  array<string, mixed>  $attributes
     */
    public function update(Model|int|string $model, array $attributes): Model;

    /**
     * Delete a record (accepts a model instance or a primary key).
     */
    public function delete(Model|int|string $model): bool;
}
