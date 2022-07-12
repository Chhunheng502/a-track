<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class ClassService
{
    public function getInvitationLink($subject, $section)
    {
        $group = Auth::user()->groups()
                    ->where('subject', $subject)
                    ->where('section', $section)
                    ->first();
            
        return 'https://a-track.herokuapp.com/classes/' . $subject . '/' . $section . '/inv/l/' . $group->invitation_token;
    }
}