<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository {
    
    protected $data;

    public function __construct(
        protected Model $model
    ) {}

    public function all(array $relations = []) {
        return $this
            ->model
            ->with($relations)
            ->get();
    }

    public function allPaginated(array $relations = [])
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

    public function findById($id, $relations = [])
    {
        $this->data = $this
            ->model
            ->with($relations)
            ->findOrFail($id);

        return $this;
    }

    public function get(){
        return $this->data;
    }
}