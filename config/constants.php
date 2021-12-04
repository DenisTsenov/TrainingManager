<?php

use App\Models\Admin\Role;
use App\Models\Admin\Permission;

return [
    'roles'       => [
        Role::TRAINER    => 'Trainer',
        Role::COMPETITOR => 'Competitor',
    ],
    'permissions' => [
        Permission::CREATE_TRAINING   => 'Create Training',
        Permission::ASSIGN_TRAINING   => 'Assign Training',
        Permission::EDIT_TRAINING     => 'Edit Training',
        Permission::ROLLBACK_TRAINING => 'Rollback Training',
        Permission::TRAINING_COMPLETE => 'Training Complete',
    ],

    'date'     => 'Y-m-d',
    'datetime' => 'd-m-Y H:i',
];
