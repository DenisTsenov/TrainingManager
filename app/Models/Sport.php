<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Sport extends Model
{
    use LaravelVueDatatableTrait;

    protected $table = 'sports';

    protected $fillable = ['name'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            $team->created_by = \Auth::id();
        });
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
}
