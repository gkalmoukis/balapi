<?php

namespace App\Http\Controllers;

use App\Models\{
    Result,
    Team
};
use Illuminate\Http\Request;
use App\Http\Resources\{ResultCollection, ResultResource, TeamCollection};
use App\Repositories\TeamRepository;

class ResultController extends Controller
{
    public function __construct(
        protected TeamRepository $teams
    ) 
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            new TeamCollection(
                $this->teams->getLeaderboard()
            )
        );
    }
}
