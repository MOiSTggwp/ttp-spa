<?php

namespace App\Http\Controllers\Auth\Discord;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class CallbackController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $user_contact = Socialite::driver('discord')->stateless()->user();
        $contact = new Contact;

        $contact->user_id = $user->id;
        $contact->contact_name = 'discord';
        $contact->contact_id = $user_contact->id;
        $contact->contact_token = $user_contact->token;

        $contact->save();

        return redirect('/users/'.$user->id.'/edit')->with(['done' => [['Добавлен новый контакт.']]], 200);
    }
}
