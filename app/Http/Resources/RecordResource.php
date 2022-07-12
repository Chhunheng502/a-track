<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'name' => $this->student->name,
            'email' => $this->student->email,
            'photo_url' => $this->student->photo_url,
            $this->mergeWhen((request('week') == 'all'), [
                'totalPresences' => $this->student->attendances()
                                            ->where('group_id', $this->group->id)
                                            ->where('present', true)
                                            ->count(),
                'totalAbsences' => $this->student->attendances()
                                            ->where('group_id', $this->group->id)
                                            ->where('present', false)
                                            ->count(),
            ]),
            $this->mergeWhen((request('week') != 'all'), [
                'presences' => $this->student->attendances()->get('present')
            ])
        ];
    }
}
