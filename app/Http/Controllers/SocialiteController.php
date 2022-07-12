<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            $user->update([
                'google_token' => $googleUser->token,
                'google_refreshToken' => $googleUser->refreshToken
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'photo_url' => $googleUser->avatar,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refreshToken' => $googleUser->refreshToken
            ]);
        }

        Auth::login($user);

        if (Cache::has('invitation_session')) {
            $session = Cache::pull('invitation_session');
            $route = 'classes/' . $session->group->subject . '/' . $session->group->section . '/inv/m/' . $session->token;

            $user->role = 'student';
            $user->save();

            return redirect($route);
        }

        if (Cache::has('group_info')) {
            $group = Cache::pull('group_info');
            $route = 'classes/' . $group->subject . '/' . $group->section . '/inv/l/' . $group->invitation_token;

            $user->role = 'student';
            $user->save();

            return redirect($route);
        }

        if (Cache::has('qr_session')) {
            $qrSession = Cache::pull('qr_session');
            $route = 'qr/sub/' . $qrSession->group->subject . '/sec/' . $qrSession->group->section . 'token/' . $qrSession->token;

            $user->role = 'student';
            $user->save();

            return redirect($route);
        }

        return redirect('admin/classes');
    }
}
