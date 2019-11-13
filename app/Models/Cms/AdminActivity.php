<?php

namespace App\Models\Cms;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';
    protected $table = 'admin_activity';
    const TABLE = 'admin_activity';
    /* dung update_at va created_at ko*/
    public $timestamps = false;


    const CONTENT_TYPE_USER="USER";
    const CONTENT_TYPE_CASHOUT="CASHOUT";





    public static function add($admin, $action = '', $content_id, $content_type, $description = '')
    {
        try {
            $odm = new self;
            $data = [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'action' => $action,
                'content_id' => $content_id,
                'content_type' => $content_type,
                'description' => $description,
                'created_time' => Carbon::now()
            ];
            $odm->create($data);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }

    } 

    public static function addData($admin, $action = '', $content_id, $content_type, $description = '',$content_data = '')
    {
        try {
            $odm = new self;
            $data = [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'action' => $action,
                'content_id' => $content_id,
                'content_type' => $content_type,
                'data' => $content_data,
                'description' => $description,
                'created_time' => Carbon::now()
            ];
            $odm->create($data);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }

    } 


    /**
     * @todo lấy ra những bản ghi activity
     * @param $content_id
     * @param $content_type
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getActivity($content_id, $content_type)
    {
        $data = AdminActivity::query()->where('content_id', '=', $content_id)
            ->where('content_type', '=', $content_type)->orderBy('id', 'desc')->get();
        return $data;
    }

    /**
     * @todo lấy ra số lượng activity dựa vào content id và content type
     * @param $content_id
     * @param $content_type
     * @return mixed
     */
    public static function getActivityCount($content_id, $content_type)
    {
        return AdminActivity::query()->where('content_id', '=', $content_id)
            ->where('content_type', '=', $content_type)->count();
    }

    public function getCreatedTime()
    {
        return date('H:i d/m/Y', strtotime($this->created_time));
    }

    public function useradmin()
    {
        return $this->hasOne(\App\Models\Admin::class, 'id','admin_id');
    } 


    public function scopeFastCheckoutLog($query)
    {
        return $query->where('content_type', \App\Common\Content::TYPE_ORDER_FAST_CHECKOUT)
        ->orderBy('id', 'desc');
    }

    public function scopePayofflineLog($query)
    {
        return $query->where('content_type', \App\Common\Content::TYPE_ORDER_PAY_OFFLINE)
        ->orderBy('id', 'desc');
    }

    public function scopeIdentityLog($query)
    {
        return $query->where('content_type', \App\Common\Content::TYPE_IDENTITY)
        ->orderBy('id', 'desc');
    }
    

}
