<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleLogin(){
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {
        try {
            $socialiteUser = Socialite::driver('google')->user();
            $user = User::where('email', $socialiteUser->getEmail())->first();
            if (!$user) {
                // Create a new user if not found
                $user = new User();
                $user->name = $socialiteUser->getName();
                $user->email = $socialiteUser->getEmail();
                $user->phone = null;
                $user->password ="123";
                $user->role = 'user';
                $user->save();
            }
            Auth::login($user);
            return redirect('/');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
