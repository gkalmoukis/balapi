<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Player;

class PlayerRepository extends BaseRepository {
    public function __construct(Player $model){
        parent::__construct($model);
    }
}