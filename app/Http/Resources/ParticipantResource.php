<?php

namespace App\Http\Resources;

class ParticipantResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'activity_id' => $this->activity_id,
            'activity'    => new ActivityResource($this->whenLoaded('activity')),
            'user_id'     => $this->user_id,
            'user'        => new UserSimpleResource($this->whenLoaded('user')),
            'remarks'     => $this->remarks,
            'created_at'  => $this->getDateTimeStr($this->created_at),
            'updated_at'  => $this->getDateTimeStr($this->updated_at),
        ];
    }
}
