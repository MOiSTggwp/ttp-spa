<?php

namespace App\Http\Controllers\Mod;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mod\ModResource;
use App\Models\Mod;
use Illuminate\Http\Request;

class ModController extends Controller
{
    public function __invoke(Request $request)
    {
        $main = json_decode($request->get('main'));
        $second = json_decode($request->get('second'));
        $res = Mod::all();

        if (!$second && $main) {
            $res = $res->whereIn('main_mod_id', $main);
        }elseif (!$main && $second) {
            $res = $res->whereIn('second_mod_id', $second);
        }elseif ($main && $second) {
            $res = $res->whereIn('main_mod_id', $main)->whereIn('second_mod_id', $second);
        }else{
            $res = $res->whereNull('main_mod_id')->whereNull('second_mod_id')->unique('tag');
        }

        return ModResource::collection($res);
    }
}
