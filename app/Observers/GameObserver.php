<?php

namespace App\Observers;

use App\Models\{Game, Result};

class GameObserver
{
    /**
     * Handle the Game "created" event.
     *
     * @param  \App\Models\Game  $game
     * @return void
     */
    public function created(Game $game)
    {
        $result = [
            "game_id" => $game->id,
            "team_id" => ($game->team_a_goals > $game->team_b_goals) ? $game->team_a_id : $game->team_b_id,
            "points" => 1
        ];

        Result::create($result);
    }

    /**
     * Handle the Game "updated" event.
     *
     * @param  \App\Models\Game  $game
     * @return void
     */
    public function updated(Game $game)
    {
        $result = [
            "game_id" => $game->id,
            "team_id" => ($game->team_a_goals > $game->team_b_goals) ? $game->team_a_id : $game->team_b_id,
            "points" => 1
        ];

        $game->result()->update($result);
    }

    /**
     * Handle the Game "deleted" event.
     *
     * @param  \App\Models\Game  $game
     * @return void
     */
    public function deleted(Game $game)
    {
        $game->result()->delete();
    }
}
