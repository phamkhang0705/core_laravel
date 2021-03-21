<?php

namespace App\Models\Cms;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';
    protected $table = 'admin_log';
    const TABLE = 'admin_log';
    const TABLE_NAME = 'cms.admin_log';
    public $timestamps = false;

    public static function getLog($content_id, $content_type)
    {
        $data = AdminLog::query()->where('content_id', '=', $content_id)
            ->where('content_type', '=', $content_type)->orderBy('id', 'desc')->get();
        return $data;
    }

    public function getCreatedTime()
    {
        return date('H:i d/m/Y', strtotime($this->created_time));
    }

    public function useradmin()
    {
        return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
    }


    public function scopeIdentityLog($query)
    {
        return $query->where('content_type', \App\Common\Content::TYPE_IDENTITY)
            ->orderBy('id', 'desc');
    }

    public function scopeUserLog($query)
    {
        return $query->where('content_type', \App\Common\Content::TYPE_USER)
            ->orderBy('id', 'desc');
    }
}
