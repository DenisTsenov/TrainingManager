<?php

namespace App\Models\Admin;

use App\Models\Admin\Settlement;
use App\Models\AdminSport;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Team extends Model
{
    use LaravelVueDatatableTrait;

    protected $table = 'teams';

    protected $fillable = ['name', 'trainer_id', 'sport_id', 'settlement_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn($team) => $team->created_by = \Auth::id());
    }

    protected $dataTableColumns = [
        'id'         => [
            'searchable' => false,
        ],
        'name'       => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ],
    ];

    protected $dataTableRelationships = [
        "belongsTo"     => [
            "trainer"    => [
                "model"       => User::class,
                "foreign_key" => "trainer_id",
                "columns"     => [
                    "first_name" => [
                        "searchable" => true,
                        "orderable"  => true,
                    ],
                ],
            ],
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
            "settlement" => [
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

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }
}
