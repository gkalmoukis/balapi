<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "team_a" => $this->teamA,
            "team_b" => $this->teamB,
            "team_a_goals" => $this->team_a_goals,
            "team_b_goals" => $this->team_b_goals,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at  
        ];
    }
}
