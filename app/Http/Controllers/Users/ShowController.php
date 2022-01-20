<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Users\ShowResource;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ShowResource
     */
    public function __invoke(Request $request, $id)
    {
        $user = User::find($id);

        return new ShowResource($user);
    }
}
