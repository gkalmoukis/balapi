<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            "name" => $this->name,
            "image" => $this->image,
            "players" => new PlayerCollection($this->whenLoaded('players')) ,
            "points" => $this->whenLoaded( 'results', (int) $this->results_sum_points),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
