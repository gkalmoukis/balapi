<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Game;

class GameRepository extends BaseRepository {
    
    public function __construct(Game $model){
        parent::__construct($model);
    }

    public function updateResult($gameId,array $result){
        return $this
            ->getById($gameId)
            ->result()
            ->update($result);
    }
}