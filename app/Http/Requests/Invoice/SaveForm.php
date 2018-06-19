<?php

namespace App\Http\Requests\Invoice;

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
        $keys = array_keys($this->get('items') ?? []);

        $rules = [
            'title'         => 'required|string|max:80',
            'client_id'     => 'required',
            'date'          => 'required|date',
            'due'           => 'nullable|date',
            'in_tax'        => '',
            'tax_rate'      => '',
            'remarks'       => 'nullable|string|max:800',
        ];


        foreach ($keys as $key) {
            if (
                $this->get('items')[$key]['_delete']
                || (empty($this->get('items')[$key]['name']) && empty($this->get('items')[$key]['price']) && empty($this->get('items')[$key]['quantity']))
            ) {
                $rules["items.{$key}._delete"] = '';
            } else {
                $rules["items.{$key}.name"] = 'required|string|max:100';
                $rules["items.{$key}.price"] = 'required|integer';
                $rules["items.{$key}.quantity"] = 'required|between:1,100';
            }
        }
        return $rules;
    }
}
