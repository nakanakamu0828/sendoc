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
        return [
            'name'      => trans('db.attributes.user_profile.name'),
            'birthday'  => trans('db.attributes.user_profile.birthday'),
            'tel'       => trans('db.attributes.user_profile.tel'),
            'url'       => trans('db.attributes.user_profile.url'),
        ];
    }
}
