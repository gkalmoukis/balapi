<?php

namespace App\Observers;

use App\Models\{Game, Result};
use Illuminate\Support\Facades\Log;
use Spatie\SlackAlerts\Facades\SlackAlert;


class GameObserver
{
    /**SlackAlert
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
            "points" => 1,
            "championship_id" => $game->championship_id ?? null
        ];

        Result::create($result);
        
        $slackLogText = (! is_null($game->championship_id)) ? ":soccer: {$game->championship->title} | "  : ":soccer: ";  
        $slackLogText .=  "{$game->teamA->name} {$game->team_a_goals} - {$game->team_b_goals} {$game->teamB->name} :soccer:";
        
        Log::info($slackLogText);
        
        if(config('slack-alerts.must_notify')){
            SlackAlert::message($slackLogText);
        }
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
            "points" => 1,
            "championship_id" => $game->championship_id ?? null
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
