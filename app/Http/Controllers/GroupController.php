<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\ClassService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Classes/Index', [
            'classItems' => Auth::user()->groups
        ]);
    }

    public function show($subject, $section)
    {
        $group = Group::with(['registrations' => function($query) {
                            $query->with('student')->filter(request(['search']));
                        }])
                        ->where('subject', $subject)
                        ->where('section', $section)
                        ->first();

        return Inertia::render('Admin/Classes/Detail/Index', [
            'classItem' => $group,
            'invitationLink' => (new ClassService)->getInvitationLink($subject, $section)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['required'],
            'section' => ['required'],
            'sessions.*.weekday' => ['required'],
            'sessions.*.start_at' => ['required'],
            'sessions.*.end_at' => ['required']
        ]);

        try {
            $invitation_token = Str::random(25);
        
            Auth::user()->groups()->create($request->merge([
                'invitation_token' => $invitation_token
            ])->all());
    
            return redirect()->back();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return redirect()->back()->withErrors([
                    'message' => 'This class is already created.'
                ]);
            }
        }
    }
}
