<?php

namespace App\Filters\Championship;

use App\Filters\FilterInterface;

class Status implements FilterInterface
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value): void
    {
        switch ($value) {
            case 'closed':
                $this->query->finished();
                break;
            case 'open':
                $this->query->open();
                break;
        } 
    }
}