<?php

namespace App\Http\Controllers\Profile\Edit;


use App\Http\Controllers\Controller;
use App\Http\Requests\Users\EditRequest;
use App\Models\ColorElementUser;
use App\Models\Game;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Users\ShowResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param EditRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */
    public function __invoke(EditRequest $request, $id)
    {
        $user = User::find($id);
        $profile = Profile::all()->where('user_id', $user->id)->first();

        if($user->id != $profile->user_id) {
            return response(['errors' => [['Ошибка обновления.']]], 403);
        }

        $data = $request->validated();

        if(\Arr::has($data, 'img')) {
            $img = $data['img'];

            $img_name = Carbon::now()->format('d-m-Y_H-i-s') . '_' . $user->id . '.svg';

            if($profile) {
                Storage::disk('public')->delete('images/' . $profile->img_path);
            }

            $file_path = Storage::disk('public')->put('images/' . $img_name, $img);
        }

        if(!$profile)
        $profile = new Profile;

        $profile->user_id = $user->id;

        if(\Arr::has($data, 'date'))
        $profile->date = $data['date'];

        $profile->floor = $data['floor'];
        if(\Arr::has($data, 'img')) {
            $profile->img_path = $img_name;
            $profile->img_url = url('/storage/images/' . $img_name);
        }

        if(\Arr::has($data, 'description'))
        $profile->description = $data['description'];

        $profile->save();

        if(\Arr::has($data, 'games')) {
            $user->games()->sync($data['games']);
        } else {
            $user->games()->sync([]);
        }

        if(\Arr::has($data, 'img_edit')) {
            collect(json_decode($data['img_edit'], true))->map(function ($i) use ($user) {
                $i['user_id'] = $user->id;
                $user->avatar()->save(new ColorElementUser($i));
                return $i;
            });

        }

        if(Arr::has($data, 'name')) {
            $user->name = $data['name'];
            $user->save();
        }

        return response(['done' => [['Данные обновлены.']]], 200);
    }
}
