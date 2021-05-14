<?php

namespace App\Http\Requests\Auth;

use App\Models\Admin\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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
            "name"          => ['required', 'min:2', 'max:150'],
            "trainer_id"    => ['required',
                                Rule::exists('users', 'id')->where(function ($query) {
                                    return $query->where('role_id', Role::TRAINER);
                                }),
            ],
            "sport_id"      => ['required', 'exists:sports,id'],
            "settlement_id" => ['required', 'exists:settlements,id',
                                Rule::exists('settlement_sport')
                                    ->where('sport_id', $this->input('sport_id'))
                                    ->where('settlement_id', $this->input('settlement_id')),
            ],
        ];
    }

    public function messages()
    {
        return ['exists' => 'There is no such a value'];
    }
}
