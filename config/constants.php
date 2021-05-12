<?php

use App\Models\Admin\Role;

return [
    'roles' => [
        Role::TRAINER    => 'Trainer',
        Role::COMPETITOR => 'Competitor',
    ],

    'date'     => 'Y-m-d',
    'datetime' => 'd-m-Y H:i',
];
