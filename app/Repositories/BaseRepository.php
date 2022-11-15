<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository {

    protected $data;

    public function __construct(
        protected Model $model
    ) {}

    public function getAll(array $relations = []) {
        return $this
            ->model
            ->with($relations)
            ->get();
    }

    public function getAllPaginated(array $relations = [])
    {
        return $this
            ->model
            ->orderByDesc('created_at' )
            ->with($relations)
            ->paginate();
    }

    public function create(array $attributes)
    {
        return $this
            ->model
            ->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this
            ->getById($id)
            ->update($attributes);
    }

    public function delete($id)
    {
        return $this
            ->getById($id)
            ->delete();
    }

    public function getById($id, $relations = [])
    {
        return $this
            ->model
            ->with($relations)
            ->findOrFail($id);
    }
}