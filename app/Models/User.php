<?php

namespace App\Models;

use App\Models\Admin\Role;
use App\Models\Admin\Settlement;
use App\Models\Admin\Sport;
use App\Models\Admin\Team;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, LaravelVueDatatableTrait;

    const SEED = 20;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role_id', 'settlement_id', 'sport_id', 'team_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin'   => 'boolean',
        'created_at' => 'datetime:Y-m-d',
    ];

    protected $dataTableColumns = [
        'id'         => [
            'searchable' => false,
        ],
        'first_name' => [
            'searchable' => true,
        ],
        'last_name'  => [
            'searchable' => true,
        ],
        'email'      => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ],
    ];

    protected $dataTableRelationships = [
        "belongsTo"     => [
            "sport"      => [
                "model"       => Sport::class,
                "foreign_key" => "sport_id",
                "columns"     => [
                    "name" => [
                        "searchable" => true,
                        "orderable"  => true,
                    ],
                ],
            ],
            "settlement" => [ // TODO: Check from time to time if the search bug is fixed
                              "model"       => Settlement::class,
                              "foreign_key" => "settlement_id",
                              "columns"     => [
                                  "name" => [
                                      "searchable" => true,
                                      "orderable"  => true,
                                  ],
                              ],
            ],
        ],
        "hasMany"       => [],
        "belongsToMany" => [],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function settlement()
    {
        return $this->belongsTo(Settlement::class)->withTrashed();
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class)->withTrashed();
    }

    public function membershipHistory()
    {
        return $this->belongsToMany(Team::class, 'team_member_history')
                    ->withPivot('joined_at', 'left_at');
    }

    public function membershipHistoryOrderByDesc()
    {
        return $this->membershipHistory()->as('history')->orderByDesc('id');
    }

    /**
     * @param        $query
     * @param string $identifier
     * @return mixed
     */
    public function scopeLike($query, string $identifier)
    {
        return $query->whereRaw("full_name LIKE ?", "$identifier%")
                     ->orWhereRaw("email LIKE ?", "$identifier%");
    }

    public function scopeNotAdmin($query)
    {
        return $query->where('is_admin', 0);
    }

    public function scopeTrainers($query)
    {
        return $query->where('role_id', Role::TRAINER);
    }

    public function scopeNotTrainers($query)
    {
        return $query->where(function ($query) {
            $query->where('role_id', '<>', Role::TRAINER)
                  ->orWhere('role_id', null);
        });
    }

    public function scopeForDistribution($query)
    {
        return $query->whereNull('team_id')->notAdmin()->notTrainers();
    }

    public function scopeInactiveTrainers($query)
    {
        return $query->trainers()->whereNotNull('deleted_at');
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public static function createOrUpdateMembership(array $members, int $teamId): void
    {
        $leftMembers = collect(self::where('team_id', $teamId)->pluck('id'))->diff($members);

        if (count($members)) {
            self::whereIn('id', $members)->update(['team_id' => $teamId]);
        }

        if ($leftMembers->count()) {
            self::whereIn('id', $leftMembers)->notTrainers()->update(['team_id' => null]);
        }
    }

    public static function createOrUpdateHistory(Team $team, array $members, ?int $requestTrainerId = null)
    {
        if ($requestTrainerId) {
            if ($team->trainer_id <> $requestTrainerId) {
                $teamTrainerHistory = $team->trainer->membershipHistoryOrderByDesc->first();
                $teamTrainerHistory->history->update(['left_at' => now()]);

                User::firstWhere('id', $requestTrainerId)
                    ->membershipHistory()
                    ->attach($team->id, ['joined_at' => now()]);
            }

            $leftMembers = collect(self::where('team_id', $team->id)->notTrainers()->pluck('id'))->diff($members);

            if ($leftMembers->count()) {
                self::leftTeam($team, $leftMembers->toArray());
            }

            if (count($members)) {
                self::joinTeam($team, $members);
            }

            return;
        }

        $members = $team->members();

        foreach ($members as $member) {
            $member->membershipHistory()->attach($team->id, ['joined_at' => now()]);
        }
    }

    private static function leftTeam(Team $team, array $leftMembers)
    {
        $leftMembers = self::whereIn('id', $leftMembers)->notTrainers()->get();
        foreach ($leftMembers as $member) {
            DB::table('team_member_history')
              ->where('team_id', $team->id)
              ->where('user_id', $member->id)
              ->whereNull('left_at')
              ->update(['left_at' => now()]);
        }
    }

    private static function joinTeam(Team $team, array $members)
    {
        $members = self::whereIn('id', $members)->get();
        foreach ($members as $member) {
            // If user is already in the team there is no need to perform any action
            if ($team->id == $member->team_id) continue;

            if (!optional($member->membershipHistoryOrderByDesc->whereNotNull('left_at')->first())->history) {
                $member->membershipHistory()->attach($team->id, ['joined_at' => now()]);
            }
        }
    }

    /**
     * Route notifications for the Mail channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     * @return string|null
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
