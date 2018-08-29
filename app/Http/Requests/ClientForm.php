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
            'name'          => 'required|string|max:80',
            'contact_name'  => 'nullable|string|max:80',
            'email'         => 'nullable|string|email|max:191',
            'postal_code'   => 'nullable|string|max:8',
            'address1'      => 'nullable|string|max:191',
            'address2'      => 'nullable|string|max:191',
            'address3'      => 'nullable|string|max:191',
            'remarks'       => 'nullable|string|max:1000',
        ];
    }

    public function attributes()
    {
        $keys = array_keys($this->rules());
        return array_combine($keys, array_map(function($k) { return trans('db.attributes.client.' . $k); }, $keys));
    }
}
