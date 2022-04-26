<?php

namespace App\Http\Resources;

class TopicResource extends Resource
{
    /**
     * eg User::all()->keyBy->id.
     *
     * @var bool
     */
    public $preserveKeys = false;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'topic_name' => $this->topic_name,
            'remarks'    => $this->remarks,
            'created_by' => $this->created_by,
            'created_at' => $this->getDateTimeStr($this->created_at),
            'updated_at' => $this->getDateTimeStr($this->updated_at),
        ];
    }
}
