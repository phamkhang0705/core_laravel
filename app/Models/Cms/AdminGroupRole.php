<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class AdminGroupRole extends Model
{
    protected $guarded = [];

    protected $table = 'admin_group_role';

    const TABLE_NAME = 'gigabank_cms.admin_group_role';
    const TABLE = 'admin_group_role';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';

}
