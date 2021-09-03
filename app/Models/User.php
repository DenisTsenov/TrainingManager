<?php

namespace App\Models;

use App\Models\Admin\Member;
use App\Models\Admin\Role;
use App\Models\Admin\Team;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use App\Models\Admin\Sport;
use App\Models\Admin\Settlement;

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
        'first_name', 'last_name', 'email', 'password', 'role_id', 'settlement_id', 'sport_id',
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
        return $this->hasOne(Team::class, 'trainer_id');
    }

    public function membership()
    {
        return $this->belongsTo(Member::class, 'id', 'competitor_id');
    }

    public function settlement()
    {
        return $this->belongsTo(Settlement::class)->withTrashed();
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class)->withTrashed();
    }

    /**
     * @param        $query
     * @param string $identifier
     * @return mixed
     */
    public function scopeWhereLike($query, string $identifier)
    {
        return $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", "$identifier%")
                     ->orWhereRaw("email LIKE ?", "$identifier%");
    }

    public function scopeNotAdmin($query)
    {
        return $query->where('is_admin', 0);
    }

    public function scopeTrainers($query)
    {
        return $query->where('role_id', Role::TRAINER)->orderBy('first_name');
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

    /**
     * Route notifications for the Mobica channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     * @return string|null
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
