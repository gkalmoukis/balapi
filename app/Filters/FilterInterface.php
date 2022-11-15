<?php

namespace App\Filters;

interface FilterInterface
{
    public function handle($value): void;
}