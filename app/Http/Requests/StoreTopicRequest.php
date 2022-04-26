<?php

namespace App\Http\Requests;

use App\Rules\UniqueTopicName;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
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
        $createdBy = $this->user()->id;

        return [
            'topic_name' => [
                'required',
                'max:200',
                new UniqueTopicName($createdBy),
            ],
            'remarks' => 'sometimes|max:500',
        ];
    }

    /**
     * If you would like to add an "after" validation hook to a form request, you may use the withValidator method.
     *
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // $validator->errors()->add('field', 'Something is wrong with this field!');
        });
    }

    protected $stopOnFirstFailure = true;

    protected $redirect = '/login';

    protected $redirectRoute = 'auth.login';

    public function messages()
    {
        return [
            'topic_name.required' => ':attribute不能为空',
            'topic_name.max'      => ':attribute长度不能超过:max',
            'remarks.max'         => ':attribute长度不能超过:max',
        ];
    }

    public function attributes()
    {
        return [
            'topic_name' => '主题名称',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'remarks' => $this->remarks ?: '',
        ]);
    }
}
