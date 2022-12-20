<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Resources\Games\GamesResource;
use App\Models\Game;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $games = Game::with('users')->find($id);
//        dd(new GamesResource($games));
        return GamesResource::make($games);
    }
}
