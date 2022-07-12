<?php

namespace App\Services;

class AttendanceService
{
    public function recordAllStudents($qrSession)
    {
        $registrations = $qrSession->group->registrations;

        foreach ($registrations as $registration) {
            $registration->student->attendances()->create([
                'group_id' => $qrSession->group->id,
                'qr_session_id' => $qrSession->id
            ]);
        }
    }
}