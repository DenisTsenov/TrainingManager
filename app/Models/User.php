<?php

namespace App\Models;

use App\Models\Admin\Role;
use App\Models\Admin\Team;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
        'is_admin' => 'boolean',
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

    /**
     * @param $value
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
