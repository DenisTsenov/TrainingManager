<?php

namespace App\Http\Requests\Auth\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDistributionRequest extends FormRequest
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
            'user_id' => [
                'required',
                'bail',
                Rule::exists('users', 'id')->where(fn($query) => $query->whereNull('team_id')),
            ],
            'team_id' => [
                'required',
                'bail',
                Rule::exists('teams', 'id')->where(fn($query) => $query->whereNull('deleted_at')),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'user',
            'team_id' => 'team',
        ];
    }
}
