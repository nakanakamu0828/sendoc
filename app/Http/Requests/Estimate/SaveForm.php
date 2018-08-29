<?php

namespace App\Http\Requests\Estimate;

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
            'date'          => 'required|date',
            'due'           => 'nullable|date',
            'sender'        => 'required|string|max:80',
            'recipient'     => 'required|string|max:80',
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

    public function attributes()
    {
        $keys = array_filter(array_keys($this->rules()), function($i) { return !preg_match('/^items/', $i); });
        $attributes = array_combine($keys, array_map(function($k) { return __('db.attributes.estimate.' . $k); }, $keys));

        $items = array_keys($this->get('items') ?? []);
        foreach ($items as $key) {
            $attributes["items.{$key}.name"] = __('db.attributes.estimate_item.name');
            $attributes["items.{$key}.price"] = __('db.attributes.estimate_item.price');
            $attributes["items.{$key}.quantity"] = __('db.attributes.estimate_item.quantity');
        }

        return $attributes;
    }
}
