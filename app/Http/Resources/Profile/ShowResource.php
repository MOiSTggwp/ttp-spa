<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\Contacts\ContactsResource;
use App\Http\Resources\Games\GamesResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $year = 0;
        $year_text = '';
        $age = null;

        if($this->date) {
            $year = Carbon::now()->diff(Carbon::createFromFormat('Y-m-d', $this->date))->y;
            $year_text = 'лет';

            if($year === 21 || $year === 31 || $year === 41 || $year === 51  || $year === 61) {
                $year_text = 'год';
            } elseif ($year >= 22 && $year < 25 || $year >= 32 && $year < 35 || $year >= 42 && $year < 45 || $year >= 52 && $year < 55) {
                $year_text = 'года';
            }

            $age = $year.' '.$year_text;
        }

        $games = GamesResource::collection(User::find($this->user_id)->games);
        $contacts = ContactsResource::collection(User::find($this->user_id)->contacts);

//        User::find($this->user_id)->games
        return [
            'img_url' => $this->img_url,
            'img_path' => $this->img_path,
            'date' => $this->date,
            'age' => $age,
            'floor' => $this->floor,
            'floor_text' => $this->floor === 1 ? 'Мужской' : 'Женский',
            'description' => $this->description,
            'games' => $games,
            'contacts' => $contacts,
        ];
    }
}
