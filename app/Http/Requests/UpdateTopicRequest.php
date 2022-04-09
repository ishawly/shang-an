<?php

namespace App\Http\Requests;

class UpdateTopicRequest extends StoreTopicRequest
{
    public function authorize()
    {
        return $this->topic->created_by == $this->user()->id;
    }

    public function rules()
    {
        $topicName = $this->topic->topic_name;

        $rules = parent::rules();
        $rules['topic_name'] = [
            'required',
            'max:200',
            function ($attribute, $value, $fail) use ($topicName) {
                if ($topicName == $value) {
                    $fail( '主题名称: ' . $value .'已存在');
                }
            }
        ];

        return $rules;
    }
}
