<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic_id' => 'required',
            'start_at' => 'required|date',
            'end_at'   => 'required|date|after:start_at',
            'remarks'  => 'sometimes|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'topic_id.required' => ':attribute必填',
            'start_at.required' => ':attribute必填',
            'start_at.date'     => ':attribute要求日期格式',
            'end_at.required'   => ':attribute必填',
            'end_at.date'       => ':attribute要求日期格式',
            'end_at.after'      => ':attribute要求晚于开始时间',
            'remarks.string'    => ':attribute要求为字符串',
            'remarks.max'       => ':attribute字符串长度不能超过:max',
        ];
    }

    public function attributes()
    {
        return [
            'topic_id' => '主题编号',
            'start_at' => '开始时间',
            'end_at'   => '结束时间',
            'remarks'  => '备注',
        ];
    }
}
