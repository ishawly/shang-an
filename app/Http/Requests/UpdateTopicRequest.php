<?php

namespace App\Http\Requests;

use App\Models\Topic;

class UpdateTopicRequest extends StoreTopicRequest
{
    public function authorize()
    {
        return $this->topic->created_by == $this->user()->id;
    }

    public function rules()
    {
        $createdBy = $this->user()->id;

        $rules               = parent::rules();
        $rules['topic_name'] = [
            'required',
            'max:200',
            function ($attribute, $value, $fail) use ($createdBy) {
                $topic = Topic::query()->where('created_by', $createdBy)
                    ->where('topic_name', $value)
                    ->first();
                if ($topic) {
                    $fail('主题名称: ' . $value . '已存在');
                }
            },
        ];

        return $rules;
    }
}
