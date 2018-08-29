<?php

namespace App\Http\Requests\Setting\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateForm extends FormRequest
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
            'name'      => 'required|string|max:100',
            'birthday'  => 'nullable|date',
            'tel'       => 'nullable|string|max:20',
            'url'       => 'nullable|url',
        ];
    }

    public function attributes()
    {
        $keys = array_keys($this->rules());
        return array_combine($keys, array_map(function($k) { return trans('db.attributes.user_profile.' . $k); }, $keys));
    }
}
