<?php

namespace App\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;

class SearchForm extends FormRequest
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
            'name'          => 'max:40',
            'email'         => 'max:40',
            'contact_name'  => 'max:40',
        ];
    }
}
