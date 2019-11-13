<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    protected $guarded = [];

    protected $table = 'admin_group';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';

    const CODE_MERCHANT = 'MERCHANT';

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, AdminGroupRole::TABLE, 'admin_group_id', 'admin_role_id')
            ->withPivot(['action']);
    }
}
