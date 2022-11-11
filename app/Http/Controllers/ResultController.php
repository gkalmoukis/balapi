<?php

namespace App\Http\Controllers;

use App\Models\{
    Result,
    Team
};
use Illuminate\Http\Request;
use App\Http\Resources\{ResultCollection, ResultResource, TeamCollection};

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::with('players')
            ->with('results')
            ->withSum('results', 'points')
            ->orderBy('results_sum_points', 'desc')
            ->get();
        
        return response()->json(new TeamCollection($teams));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }
}
