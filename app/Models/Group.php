<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    
    protected $fillable = ['subject', 'section', 'sessions', 'thumbnail', 'invitation_token'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function invitationSessions()
    {
        return $this->hasMany(InvitationSession::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    protected function subject(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => str_replace('-', ' ', strtoupper($value)),
            set: fn ($value) => str_replace(' ', '-', strtolower($value)),
        );
    }

    protected function sessions(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['subject'] ?? false, fn($query, $subject) =>
            $query->where(fn($query) =>
                $query->where('subject', 'like', '%' . $subject . '%')
            )
        );

        $query->when($filters['section'] ?? false, fn($query, $section) =>
            $query->where(fn($query) =>
                $query->where('section', 'like', '%' . $section . '%')
            )
        );

        // $query->when($filters['search'] ?? false, fn($query, $search) =>
        //     $query->whereHas('registrations', fn ($query) =>
        //         $query->whereHas('student', fn ($query) => 
        //             $query->where('name', $search)
        //         )
        //     )
        // );
    }
}
