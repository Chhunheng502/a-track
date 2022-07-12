<?php

namespace App\Services;

use App\Models\QrSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class QrService
{
    public function storeSession($token, $request)
    {
        $group = Auth::user()->groups()
                        ->where('subject', $request->subject)
                        ->where('section', $request->section)
                        ->first();

        $qrSession = QrSession::create([
            'group_id' => $group->id,
            'token' => $token
        ]);

        return $qrSession;
    }

    public function validateQrSession($token)
    {
        return Cache::has($token);
    }

    public function getQrSession($token)
    {
        return QrSession::where('token', $token)->first();
    }
}