<?php

namespace App\Http\Requests\Setting\Account;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

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
            'email'         => 'required|string|email|max:191|unique:users,email,' . Auth::user()->id . ',id',
            'password'      => 'nullable|string|min:8|max:40',
        ];
    }

    public function attributes()
    {
        return [
            'email'         => trans('db.attributes.user.email'),
            'password'      => trans('db.attributes.user.password'),
        ];
    }
}
