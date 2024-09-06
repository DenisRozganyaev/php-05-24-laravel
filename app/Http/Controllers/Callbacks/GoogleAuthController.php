<?php

namespace App\Http\Controllers\Callbacks;

use App\Enums\Role;
use App\Events\SocialiteCreatedAccountEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleResponse = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleResponse->getEmail())->first();

        if (! $user) {
            $password = Str::password(rand(8, 16));
            $user = User::updateOrCreate([
                'name' => $googleResponse->offsetGet('given_name'),
                'lastname' => $googleResponse->offsetGet('family_name'),
                'email' => $googleResponse->getEmail(),
                'phone' => null,
                'birthdate' => null,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::CUSTOMER->value);
            SocialiteCreatedAccountEvent::dispatch($user, $password);
        }

        auth()->login($user);

        return redirect()->route('home');
    }
}
