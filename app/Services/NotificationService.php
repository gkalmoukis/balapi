<?php

namespace App\Services;

use App\Models\Game;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Illuminate\Support\Facades\Log;


class NotificationService
{
    protected $message;

    public function __construct(protected Game $game) {}

    public function createMessage()
    {
        $message = (! is_null($this->game->championship_id)) ? ":soccer: {$this->game->championship->title} | "  : ":soccer: ";  
        $message .=  "{$this->game->teamA->name} {$this->game->team_a_goals} - {$this->game->team_b_goals} {$this->game->teamB->name} :soccer:";
        
        $this->message = $message;
        
        return $this;    
    }

    public function toSlack(){
        SlackAlert::message($this->message);   
    }
    
    public function toFile(){
        Log::info($this->message);
    }
}