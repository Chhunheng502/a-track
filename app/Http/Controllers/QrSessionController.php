<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupCollection;
use App\Jobs\ClearQrSession;
use App\Services\AttendanceService;
use App\Services\QrService;
use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QrSessionController extends Controller
{
    public function index()
    {
        $groups = new GroupCollection(Auth::user()->groups);

        return Inertia::render('Admin/QrCode/Index', [
            'classItems' => $groups,
            'qrCode' => Cookie::get('qr_code'),
            'qrExpiredDate' => Cookie::get('qr_expired_date')
        ]);
    }

    public function store(Request $request)
    {
        $token = Str::random(25);
        
        $data = 'https://a-track.herokuapp.com/qr/sub/' . $request->subject .  '/sec/' . $request->section . '/' . $token;

        $qrSession = (new QrService)->storeSession($token, $request);
        
        Cache::put($qrSession->token, $qrSession->token, $request->duration * 60);
        (new AttendanceService)->recordAllStudents($qrSession);

        $qrCode = (new QRCode)->render($data);
        $expired_date = Carbon::now()->addMinutes($request->duration)->toDateTimeString();

        Cookie::queue(Cookie::make('qr_code', $qrCode, $request->duration));
        Cookie::queue(Cookie::make('qr_expired_date', $expired_date, $request->duration));

        return redirect()->back();
    }
}
