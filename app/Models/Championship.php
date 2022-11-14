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

    public function scopeOpen($query)
    {
        return $query->whereNull('finished_at');
    }

    public function scopeFinished($query)
    {
        return $query->whereNotNull('finished_at');
    }
}
