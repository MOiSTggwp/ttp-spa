<?php

namespace App\Http\Controllers\Profile\Edit;


use App\Http\Controllers\Controller;
use App\Http\Requests\Users\EditRequest;
use App\Models\Game;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
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

            $img_name = md5(Carbon::now() . '_' . $img->getClientOriginalName() . '.' . $img->getClientOriginalExtension());

            if($profile) {
                Storage::disk('public')->delete($profile->img_path);
            }

            $file_path = Storage::disk('public')->putFileAs('/images', $img, $img_name);
        }

        if(!$profile)
        $profile = new Profile;

        $profile->user_id = $user->id;

        if(\Arr::has($data, 'date'))
        $profile->date = $data['date'];

        $profile->floor = $data['floor'];
        if(\Arr::has($data, 'img')) {
            $profile->img_path = $file_path;
            $profile->img_url = url('/storage/' . $file_path);
        }

        if(\Arr::has($data, 'description'))
        $profile->description = $data['description'];

        $profile->save();

        if(\Arr::has($data, 'games')) {
            $user->games()->sync($data['games']);
        } else {
            $user->games()->sync([]);
        }

        if(Arr::has($data, 'name')) {
            $user->name = $data['name'];
            $user->save();
        }

        return response(['done' => [['Данные обновлены.']]], 200);
    }
}
