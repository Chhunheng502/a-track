<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupCollection;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $groupsData = new GroupCollection(Auth::user()->groups);

        $attendanceData = Auth::user()->groups()
            ->with(['registrations' => function($query) {
                $query->with(['student' => function($query) {
                    $query->with(['attendances' => function($query) {
                        $query->filter(request(['subject', 'section', 'week']));
                    }]);
                }])
                ->filter(request(['search']));
            }])
            ->filter(request(['subject', 'section']))
            ->first();

        return Inertia::render('Admin/Report/Index', [
            'classItems' => $groupsData,
            'attendanceData' => $attendanceData,
            'filters' => [
                'subject' => request('subject'),
                'section' => request('section'),
                'week' => request('week')
            ]
        ]);
    }
}
