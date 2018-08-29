<?php

namespace App\Http\Requests\Source;

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
        $keys = array_keys($this->get('payees') ?? []);

        $rules = [
            'name'          => 'required|string|max:80',
            'contact_name'  => 'nullable|string|max:80',
            'email'         => 'nullable|string|email|max:191',
            'postal_code'   => 'nullable|string|max:8',
            'address1'      => 'nullable|string|max:191',
            'address2'      => 'nullable|string|max:191',
            'address3'      => 'nullable|string|max:191',
            'remarks'       => 'nullable|string|max:1000',
        ];


        foreach ($keys as $key) {
            if (
                $this->get('payees')[$key]['_delete']
                || (empty($this->get('payees')[$key]['details']))
            ) {
                $rules["payees.{$key}._delete"] = '';
            } else {
                $rules["payees.{$key}.detail"] = 'required|string|max:100';
            }
        }
        return $rules;
    }

    public function attributes()
    {
        $keys = array_filter(array_keys($this->rules()), function($i) { return !preg_match('/^payees/', $i); });
        $attributes = array_combine($keys, array_map(function($k) { return __('db.attributes.source.' . $k); }, $keys));

        $payees = array_keys($this->get('payees') ?? []);
        foreach ($payees as $key) {
            $attributes["payees.{$key}.detail"] = __('db.attributes.payee.detail');
        }
        return $attributes;
    }
}
