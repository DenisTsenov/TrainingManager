<?php

namespace App\Enums;

enum Menu: string
{
    case LOGIN    = 'login';
    case REGISTER = 'register';
    case WELCOME  = 'welcome';

    case PROFILE               = 'profile';
    case SUB_MENU_EDIT_PROFILE = 'edit-profile';
    case SUB_MENU_HISTORY      = 'history';

    case ADMIN                                  = 'admin';
    case SUB_MENU_MANAGE_USER_ROLES_PERMISSIONS = 'manage-user-roles';
    case SUB_MENU_MANAGE_ROLE_PERMISSIONS       = 'manage-role-permissions';
    case SUB_MENU_TEAM                          = 'team';
    case SUB_MENU_SETTLEMENTS                   = 'settlements';
    case SUB_MENU_SETTLEMENTS_LIST              = 'settlements-list';
    case SUB_MENU_SETTLEMENT_CREATE_EDIT        = 'settlement-create-edit';
    case SUB_MENU_SPORTS                        = 'sports';
    case SUB_MENU_SPORTS_LIST                   = 'sports-list';
    case SUB_MENU_SPORT_CREATE_EDIT             = 'sport-create-edit';
}
