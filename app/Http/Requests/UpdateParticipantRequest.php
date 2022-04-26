<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'remarks' => 'sometimes|max:500',
        ];
    }

    public function messages()
    {
        return [
            'remarks.max' => ':attribute长度不能超过:max',
        ];
    }

    public function attributes()
    {
        return [
            'remarks' => '备注',
        ];
    }
}
