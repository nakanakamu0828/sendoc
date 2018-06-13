<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientForm extends FormRequest
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
            'name'          => 'required|string|max:255',
            'contact_name'  => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'postal_code'   => 'required|string|max:8',
            'prefecture_id' => 'required',
            'address1'      => 'required|string|max:255',
            'address1'      => 'nullable|string|max:255',
            'remarks'       => '',
        ];
    }
}
