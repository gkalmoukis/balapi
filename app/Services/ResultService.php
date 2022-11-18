<?php

namespace App\Services;

use App\Models\Game;

class ResultService
{
    public function __construct(protected Game $game) {}

    public function buildResult(){
        return [
            "game_id" => $this->game->id,
            "team_id" => $this->detectWinner(),
            "points" => $this->calculatePoints(),
            "championship_id" => $this->game->championship_id ?? null
        ];
    }

    private function detectWinner(){
        return $this->game->team_a_goals > $this->game->team_b_goals 
            ? $this->game->team_a_id 
            : $this->game->team_b_id;
    }

    private function calculatePoints(){
        if($this->game->team_a_goals == $this->game->team_b_goals){
            return 0;
        }

        if($this->game->team_a_goals > $this->game->team_b_goals){
            return ($this->game->team_a_goals == 7 && $this->game->team_b_goals == 0 ) ? 2 : 1;
        }
        else if($this->game->team_a_goals < $this->game->team_b_goals){
            return ($this->game->team_b_goals == 7 && $this->game->team_a_goals == 0 ) ? 2 : 1;
        }
    }
}