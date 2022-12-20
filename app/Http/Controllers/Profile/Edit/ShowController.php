<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\ShowResource;
use App\Models\User;
use Illuminate\Http\Request;

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
