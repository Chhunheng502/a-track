<?php

namespace App\Mail;

use App\Models\Group;
use App\Models\InvitationSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $recipient;
    protected $group;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, Group $group)
    {
        $this->recipient = $recipient;
        $this->group = $group;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = Str::random(25);

        $this->group->invitationSessions()->create([
            'student_email' => $this->recipient,
            'token' => $token,
            'valid' => true
        ]);

        return $this->from('Chhunheng@gmail.com', 'Chhunheng Leng')
        ->markdown('emails.invitation', [
            'url' => 'https://a-track.herokuapp.com/classes/' . $this->group->subject . '/' . $this->group->section . '/inv/m/' . $token,
        ]);
    }
}
