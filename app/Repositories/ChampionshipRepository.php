<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Championship;

class ChampionshipRepository extends BaseRepository {
    
    public function __construct(Championship $model){
        parent::__construct($model);
    }

    public function getAll(array $relations = [], $filters = []) {
        return $this
            ->model
            ->filterBy($filters)
            ->with($relations)
            ->get();
    }

    public function getParticipantingTeams($champtionshipId)
    {
        $championship = $this->getById($champtionshipId);

        $participatingATeams = $championship->games->map(function ($game){         
            return $game->team_a_id;
        });
       
        $participatingBTeams = $championship->games->map(function ($game){
            return $game->team_b_id;
        });

        return array_merge($participatingATeams->unique()->toArray(), $participatingBTeams->unique()->toArray());
    }

    public function close($id){
        return $this
            ->getById($id)
            ->update([
                "finished_at" => \Carbon\Carbon::now()
            ]);
    }
}