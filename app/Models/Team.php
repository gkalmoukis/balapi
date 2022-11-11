<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function players()
    {
        return $this->belongsToMany(Player::class, 'team_players');
    }

    public function results(){
        return $this->hasMany(Result::class);
    }
}
