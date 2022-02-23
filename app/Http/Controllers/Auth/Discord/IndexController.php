<?php

namespace App\Http\Controllers\Auth\Discord;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if($user->contacts->count() > 0) {
            foreach($user->contacts as $contact) {
                if($contact->contact_name === 'discord') {
                    $contact->delete();
                    return redirect()->back()->with(['done' => [['Контакт Disсord удален.']]], 200);
                }
            }
        }

        return Socialite::driver('discord')->redirect();
    }
}
