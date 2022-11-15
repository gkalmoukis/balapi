<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Team;

class TeamRepository extends BaseRepository {
    
    public function __construct(Team $model){
        parent::__construct($model);
    }

    public function attachPlayer($teamId, $player){
        return $this
            ->getById($teamId)
            ->players()
            ->attach($player);
    }

    public function detachPlayer($teamId, $playerId){
        return $this
            ->getById($teamId)
            ->players()
            ->detach($playerId);
    }

    public function getLeaderboard(){
        return $this
            ->model
            ->with('players')
            ->with('results')
            ->withSum('results', 'points')
            ->orderBy('results_sum_points', 'desc')
            ->get();
    }

    public function getChampionshipLeaderboard($championshipId, $participants){
        
        return $this
            ->model
            ->with('players')
            ->with('results')
            ->withSum(['results' => function ($query) use ($championshipId){
                $query->championship($championshipId);
            }], 'points')
            ->orderBy('results_sum_points', 'desc')
            ->whereIn('id', $participants )
            ->get();

    }
}