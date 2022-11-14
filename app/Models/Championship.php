<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championship extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
