<?php

namespace App\Models\Cms;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $fullname
 * @property string $email
 * @property string $admin_group_id
 * @property int $is_admin
 */
class Admin extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    protected $connection = 'mysql';

    protected $table = 'admin';
    const TABLE = 'admin';
    const TABLE_NAME = 'deal365.admin';


    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    protected $guarded = [];

    public function group()
    {
        return $this->hasOne(AdminGroup::class, 'id', 'admin_group_id');
    }

    public function getDisplayNameAttribute()
    {
        if (!empty($this->fullname)) {
            return $this->fullname;
        }

        return $this->name;
    }
}
