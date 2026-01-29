<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public const CAN_CREATE_USERS = 'create-users';
    public const CAN_UPDATE_USERS = 'update-users';
    public const CAN_DELETE_USERS = 'delete-users';
    public const CAN_ROLE_LIST = 'role-list';
    public const CAN_ROLE_CREATE = 'role-create';
    public const CAN_ROLE_EDIT = 'role-edit';
    public const CAN_ROLE_DELETE = 'role-delete';
    public const CAN_VIEW_PROFILE='view-profile';
    public const CAN_EDIT_PROFILE='edit-profile';
    public const CAN_VIEW_USERS='view-users';
    public const CAN_EDIT_SETTINGS='edit-settings';
    public const CAN_CREATE_MERCHANTS='create-merchants';
    public const CAN_EDIT_MERCHANTS='edit-merchants';
    public const CAN_VIEW_MERCHANTS='view-merchants';
    public const CAN_VIEW_ALL_TRANSACTIONS='view-all-trascations';
    public const CAN_VIEW_TRANSACTIONS='view-trascations';
}
