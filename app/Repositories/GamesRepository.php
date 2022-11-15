<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Game;

class GamesRepository extends BaseRepository {
    
    public function __construct(Game $model){
        parent::__construct($model);
    }
}