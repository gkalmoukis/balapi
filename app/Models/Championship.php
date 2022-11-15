<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Championship extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];
    
    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('finished_at');
    }

    public function scopeClosed($query)
    {
        return $query->whereNotNull('finished_at');
    }
}
