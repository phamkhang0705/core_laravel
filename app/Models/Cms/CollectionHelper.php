<?php
/**
 * Created by PhpStorm.
 * User: trungnt
 * Date: 9/12/2015
 * Time: 10:24 AM
 */
namespace App\Models\Cms;

class CollectionHelper {
    /*@todo return link collection detail*/
    public static function detailLink($id) {
        return url('collection/detail',['id'=>$id]);
    }

}