<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Result;

class ResultRepository extends BaseRepository {
    public function __construct(Result $model){
        parent::__construct($model);
    }
}