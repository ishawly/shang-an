<?php

namespace App\Http\Requests;

class UpdateActivityRequest extends StoreActivityRequest
{
    public function authorize()
    {
        return $this->activity->created_by == $this->user()->id;
    }

    public function rules()
    {
        return [
            'start_at' => 'required|date',
            'end_at'   => 'required|date|after:start_at',
            'remarks'  => 'sometimes|string|max:500',
        ];
    }
}
