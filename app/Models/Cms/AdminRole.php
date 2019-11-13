<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $guarded = [];

    protected $table = 'admin_role';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';

    const STATUS_ENABLED = 'ENABLE';
    const STATUS_DISABLE = 'DISABLE';


    public static function getAllControl()
    {
        $data = AdminRole::query()
            ->where('status','ENABLE')
            ->groupBy('controller')
            ->select('controller')
            ->get();
        if(empty($data))
            return [];

        return array_column($data->toArray(), 'controller');
    }
}
