<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Http\Resources\{GameCollection, GameResource};
use App\Repositories\GamesRepository;

class GameController extends Controller
{
    public function __construct(
        protected GamesRepository $games
    ) { }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = $this->games->getAll(['teamA.players', 'teamB.players']);    
        
        return response()->json(new GameCollection($games));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $validated = $request->validated();
        
        try {
            $newGame = $this->games->create($validated);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 400);
        }
        
        return response()->json(new GameResource($newGame));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = $this->games->getById($id);

        return response()->json(new GameResource($game));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGameRequest  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $this->games->update($id, $validated);        
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 400);
        }

        $modifiedGame = $this->games->getById($id); 

        return response()->json(new GameResource($modifiedGame));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->games->delete($id);

        return response()->json([
            "message" => "Game {$id} deleted" 
        ]);
    }
}
