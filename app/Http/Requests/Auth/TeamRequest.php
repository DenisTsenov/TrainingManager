<?php

namespace App\Http\Requests\Auth;

use App\Models\Admin\Role;
use App\Models\User;
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
            "members"    => ['nullable', 'array'],
            "members.*"  => ['nullable', 'exists:users,id'],
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->errors()->count() && !empty($this->input('members'))) {
            $validator->after(function ($validator) {

                $trainer = User::find($this->trainer_id);
                $members = User::with('team')->notTrainers()->whereIn('id', $this->input('members'))->get();

                foreach ($members as $member) {
                    $memberTeamId = $member->team_id;

                    if ($memberTeamId && $memberTeamId <> $trainer->team_id) {
                        $validator->errors()->add("name", "User $member->full_name all ready in team {$member->team->name}. Please uncheck");
                    }
                }
            });
        }
    }

    public function messages()
    {
        return ['exists' => 'There is no such a value'];
    }
}
