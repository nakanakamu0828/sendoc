<?php

namespace App\Http\Requests\Member\Invitation\Email;

use Illuminate\Foundation\Http\FormRequest;

class SaveForm extends FormRequest
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
        $keys = array_keys($this->get('emails') ?? []);

        $rules = [];
        foreach ($keys as $key) {
            $rules["emails.{$key}"] = 'nullable|email|max:191';
        }

        return $rules;
    }
}
