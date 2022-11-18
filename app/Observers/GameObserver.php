<?php

namespace App\Observers;

use App\Models\{Game};
use Illuminate\Support\Facades\Log;
use Spatie\SlackAlerts\Facades\SlackAlert;
use App\Repositories\{ResultRepository, GameRepository};
use App\Services\ResultService;

class GameObserver
{

    public function __construct(
        protected ResultRepository $results,
        protected GameRepository $games
    ) {}

    public function creating(Game $game)
    {
        if(is_null($game->championship_id)){
            return true;
        }

        if(! is_null($game->championship->finished_at)){
            throw new \Exception("You can not add game on finished Championship");
        }
    }
    
    /**
     * Handle the Game "created" event.
     *
     * @param  \App\Models\Game  $game
     * @return void
     */
    public function created(Game $game)
    {
        $resultService = new ResultService($game);
        
        $this->results->create($resultService->buildResult());
        
        $slackLogText = (! is_null($game->championship_id)) ? ":soccer: {$game->championship->title} | "  : ":soccer: ";  
        $slackLogText .=  "{$game->teamA->name} {$game->team_a_goals} - {$game->team_b_goals} {$game->teamB->name} :soccer:";
        
        Log::info($slackLogText);

        if(config('slack-alerts.must_notify')){
            SlackAlert::message($slackLogText);
        }
    }

    public function updating(Game $game)
    {
        if(is_null($game->championship_id)){
            return true;
        }
        
        if(! is_null($game->championship->finished_at)){
            throw new \Exception("You can not edit a game on finished Championship");
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
        $resultService = new ResultService($game);

        $this->games->updateResult($game->id, $resultService->buildResult());
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
