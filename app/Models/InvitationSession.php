<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationSession extends Model
{
    protected $fillable = ['student_email', 'token', 'valid'];

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
