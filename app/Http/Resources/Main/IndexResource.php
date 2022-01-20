<?php

namespace App\Http\Resources\Main;

use App\Http\Resources\Profile\ShowResource;
use App\Models\Game;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'auth' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'profile' => ShowResource::make($this->profile),
            ],
            'games' => \App\Http\Resources\Games\IndexResource::collection(Game::all()->sortBy('name')),
        ];
    }
}
