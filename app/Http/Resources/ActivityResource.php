<?php

namespace App\Http\Resources;

class ActivityResource extends Resource
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
            'id' => $this->id,
            'topic_id' => $this->topic_id,
            'created_by' => $this->created_by,
            'start_at' => $this->getDateTimeStr($this->start_at),
            'end_at' => $this->getDateTimeStr($this->end_at),
            'participant_num' => (int) $this->participant_num,
            'remarks' => $this->remarks ?: '',
            'created_at'=> $this->getDateTimeStr($this->created_at),
            'updated_at' => $this->getDateTimeStr($this->updated_at),
        ];
    }
}
