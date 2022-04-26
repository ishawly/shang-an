<?php

namespace App\Rules;

use App\Models\Topic;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;

class UniqueTopicName implements Rule, DataAwareRule, ValidatorAwareRule
{
    protected $createdBy;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $topic = Topic::query()->where('created_by', $this->createdBy)
            ->where('topic_name', $value)
            ->first();

        return !$topic;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute已存在';
    }

    /**
     * custom validation rule class needs to access all of the other data undergoing validation.
     */
    protected $data = [];

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * access to the validator instance performing the validation.
     */
    protected $validator;

    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }
}
