<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GameCollection;

class ChampionshipResource extends JsonResource
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
            "title" => $this->title,
            "games" => new GameCollection($this->whenLoaded('games')),
            "teams" => new TeamCollection($this->when(! is_null($this->teams),$this->teams)),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
