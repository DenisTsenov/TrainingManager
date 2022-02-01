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
        return [
            'first_name'    => ['required', 'string', 'max:50'],
            'last_name'     => ['required', 'string', 'max:50'],
            'settlement_id' => ['required', 'exists:settlements,id',],
            'sport_id'      => ['required', 'exists:sports,id',
                                Rule::exists('settlement_sport')
                                    ->where('sport_id', $this->input('sport_id'))
                                    ->where('settlement_id', $this->input('settlement_id')),
            ],
            'email'         => ['required', 'string', 'email', Rule::unique('users')->ignore(Auth::id()),],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->errors()->count()) {
            $validator->after(function ($validator) {
                $user = $this->route('user');

                if ($user && $user->cannot('deactivateProfile', $user)) {
                    if ($this->sport_id <> $user->sport_id || $this->settlement_id <> $user->settlement_id) {
                        $validator->errors()->add('sport_id', 'wrong data');
                    }
                }
            });
        }
    }

    public function messages()
    {
        return [
            'exists'   => 'There is no such a value',
            'required' => 'Field is required',
        ];
    }
}
