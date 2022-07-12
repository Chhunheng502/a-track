<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InvitationController extends Controller
{
    public function sendMail(Request $request)
    {
        $group = Group::where('subject', $request->subject)
                        ->where('section', $request->section)
                        ->first();

        Mail::to($request->email)->send(new InvitationMail($request->email, $group));

        return redirect()->back();
    }

    public function handleMailCallback($subject, $section, $token)
    {
        
        $group = Group::where('subject', $subject)
                        ->where('section', $section)
                        ->first();

        $invitation_session = $group->invitationSessions()
                                    ->where('token', $token)
                                    ->first();
                        
        if (! Auth::user()) {
            Cache::put('invitation_session', $invitation_session, $seconds = 60 * 10);
            return redirect('auth/google');
        }

        if (! $invitation_session->valid) {
            return Inertia::render('Notification/Registration', [
                'success' => false
            ]);
        }

        Auth::user()->registrations()->create([
            'group_id' => $group->id
        ]);

        Auth::logout();

        $invitation_session->valid = false;
        $invitation_session->save();

        return Inertia::render('Notification/Registration');
    }

    public function handleLinkCallback($subject, $section, $token)
    {
        $group = Group::where('subject', $subject)
                        ->where('section', $section)
                        ->first();
                        
        if (! Auth::user()) {
            $route = 'classes/' . $subject . '/' . $section . '/inv/l/' . $token;
            Cookie::queue(Cookie::make('link_route', $route, 10));
            return redirect()->route('student.login');
        }

        Auth::user()->registrations()->create([
            'group_id' => $group->id
        ]);

        Auth::logout();

        return Inertia::render('Notification/Registration');
    }
}
