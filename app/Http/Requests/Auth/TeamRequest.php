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
            "name"       => ['required', 'min:2', 'max:250'],
            "trainer_id" => ['required',
                             Rule::exists('users', 'id')->where(fn($query) => $query->where('role_id', Role::TRAINER)),
            ],
            "members"    => ['array'],
            "members.*"  => ['exists:users,id'],
        ];
    }

    public function messages()
    {
        return ['exists' => 'There is no such a value'];
    }
}
