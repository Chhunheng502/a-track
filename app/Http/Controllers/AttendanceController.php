<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\QrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function handleQrCallback($subject, $section, $token)
    {
        
        $valid = (new QrService)->validateQrSession($token);

        if ($valid) {
            
            $qrSession = (new QrService)->getQrSession($token);
            
            if (! Auth::user()) {
                $route = 'qr/sub/' . $subject . '/sec/' . $section . '/' . $token;
                Cookie::queue(Cookie::make('qr_route', $route, 10));
                return redirect()->route('student.login.qr');
            }

            $attendance = Auth::user()
                            ->attendances()
                            ->where('qr_session_id', $qrSession->id)
                            ->first();

            $attendance->present = true;
            $attendance->save();

            Auth::logout();

            return Inertia::render('Notification/Attendance');
        }

        return Inertia::render('Notification/Attendance', [
            'success' => false
        ]);
    }
}
