<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id()),],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if (!$this->isMethod('put')) {
            $rules += [
                'settlement_id' => ['required', 'exists:settlements,id',],
                'sport_id'      => ['required', 'exists:sports,id',
                                    Rule::exists('settlement_sport')
                                        ->where('sport_id', $this->input('sport_id'))
                                        ->where('settlement_id', $this->input('settlement_id')),
                ],
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return ['exists' => 'There is no such a value'];
    }
}
