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
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id()),],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'settlement_id' => ['required', 'exists:settlements:id'],
            'sport_id'      => ['required', 'exists:sports,id'],
        ];
//        TODO test -> Rule::exists('settlements_sports')->where(function ($query) {
//                                    return $query->where('settlement_id', $this->input('settlement_id'));
//                                }),
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('settlement_id') && $this->has('sport_id')) { // TODO: test
                $settlementSport = \DB::table('settlements_sports')
                                      ->where('settlement_id', $this->input('settlement_id'))
                                      ->where('sport_id', $this->input('sport_id'))
                                      ->exists();

                if (!$settlementSport) {
                    $validator->errors()->add('sport_id', 'No such a sport in this settlement.');
                }
            }
        });
    }
}
