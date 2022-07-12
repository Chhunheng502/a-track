<?php

namespace App\Jobs;

use App\Models\QrSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearQrSession implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $qrSession;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QrSession $qrSession)
    {
        $this->qrSession = $qrSession;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->qrSession->valid = false;
        $this->qrSession->save();

        $registrations = $this->qrSession->group->registrations;

        foreach ($registrations as $registration) {
            $present = $registration->student->attendances()
            ->where('qr_session_id', $this->qrSession->id)
            ->where('present', true)
            ->exists();

            if (! $present) {
                $registration->student->attendances()->create([
                    'group_id' => $this->qrSession->group->id,
                    'qr_session_id' => $this->qrSession->id
                ]);
            }
        }

    }
}
