<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Settlement extends Model
{
    use LaravelVueDatatableTrait;
    use SoftDeletes;

    protected $table = 'settlements';

    protected $fillable = ['name'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn($team) => $team->created_by = \Auth::id());
    }

    protected array $dataTableColumns = [
        'id'         => [
            'searchable' => false,
        ],
        'name'       => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ],
        'updated_at' => [
            'searchable' => true,
        ],
    ];

    protected array $dataTableRelationships = [
        "belongsTo"     => [
            "createdBy" => [
                "model"       => User::class,
                "foreign_key" => "created_by",
                "columns"     => [
                    "first_name" => [
                        "searchable" => true,
                        "orderable"  => true,
                    ],
                ],
            ],
        ],
        "hasMany"       => [],
        "belongsToMany" => [
//            "sports" => [
//                "model"       => Sport::class,
//                "foreign_key" => "sport_id",
//                "pivot"       => [
//                    "table_name"  => "settlement_sport",
//                    "primary_key" => "id",
//                    "foreign_key" => "sport_id",
//                    "local_key"   => "settlement_id",
//                ],
//                "order_by"    => "name",
//                "columns"     => [
//                    "name" => [
//                        "searchable" => true,
//                        "orderable"  => true,
//                    ],
//                ],
//            ],
        ],
    ];

    public function sports()
    {
        return $this->belongsToMany(Sport::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
