<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
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
            'topic_name' => $this->topic_name,
            'remarks' => $this->remarks,
            'created_by' => $this->created_by,
            'created_at' => $this->getDateTimeStr($this->created_at),
            'updated_at' => $this->getDateTimeStr($this->updated_at),
        ];
    }

    private function getDateTimeStr(?Carbon $dt)
    {
        return $dt ? $dt->toDateTimeString() : '';
    }
}
