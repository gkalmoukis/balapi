<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use App\Http\Resources\{PlayerResource, PlayerCollection};
use App\Repositories\PlayerRepository;
class PlayerController extends Controller
{
    
    public function __construct(
        protected PlayerRepository $players
    ) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            new PlayerCollection(
                $this->players->getAll()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlayerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlayerRequest $request)
    {
        $validated = $request->validated();

        return response()->json(new PlayerResource(
            $this->players->create($validated)
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(new PlayerResource(
            $this->players->getById($id)
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlayerRequest  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayerRequest $request, $id)
    {
        $validated = $request->validated();

        $this->players->update($id, $validated);

        $modifiedPlayer = $this->players->getById($id); 

        return response()->json(new PlayerResource($modifiedPlayer));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->players->delete($id);

        return response()->json([
            "message" => "Player {$id} deleted" 
        ]);
    }
}
