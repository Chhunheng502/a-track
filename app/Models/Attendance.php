<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'group_id', 'qr_session_id', 'present'];

    public function scopeFilter($query, array $filters)
    {
        if (request('subject') && request('section')) {
            $group = Auth::user()->groups()
            ->where('subject', request('subject'))
            ->where('section', request('section'))
            ->first();
        } else {
            if (request('section')) {
                $group = Auth::user()->groups()
                ->where('section', request('section'))
                ->first();
            } else {
                $group = Auth::user()->groups()->first();
            }
        }

        // $query->when(($filters['subject'] && $filters['section'])  ?? false, fn($query) =>
        //     $query->where(fn($query) =>
        //         $query->where('group_id', $group->id)
        //     )
        // );

        $query->where('group_id', $group->id);
 
        $query->when($filters['week'] ?? false, function($query, $week) use ($group) {
            if ($week != 'all') {
                $query->whereBetween('created_at',
                [
                    Carbon::createFromTimeStamp(strtotime($group->created_at))->addWeeks($week - 1),
                    Carbon::createFromTimeStamp(strtotime($group->created_at))->addWeeks($week)
                ]);
            }
        });
    }
}
