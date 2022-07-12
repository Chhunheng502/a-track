<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'teacher' => $this->teacher,
            'subject' => $this->subject,
            'section' => $this->section,
            'sessions' => $this->sessions,
            'weekly' => (request('week') != 'all'),
            'records' => RecordResource::collection($this->registrations)
        ];
    }
}
