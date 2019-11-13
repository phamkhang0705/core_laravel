<?php

namespace App\Models\Cms;

class AdminHelper {
    /*@todo return link profile admin*/
    public static function detailLink($id) {
        return url('admin/detail',['id'=>$id]);
    }

}
