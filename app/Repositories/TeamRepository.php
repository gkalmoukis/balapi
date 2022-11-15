<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Team;

class TeamRepository extends BaseRepository {
    public function __construct(Team $model){
        parent::__construct($model);
    }
}