<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }
    
    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
