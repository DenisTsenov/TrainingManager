<?php

namespace App\Http\Requests\Auth\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettlementRequest extends FormRequest
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
            'name'        => ['required', 'max:50', Rule::unique('settlements')->ignore($this->settlement)],
            'sports'      => ['nullable', 'array'],
            'sports.*.id' => ['nullable', 'numeric', 'exists:sports,id'],
        ];
    }
}
