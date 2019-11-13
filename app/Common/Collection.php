<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/03/2018
 * Time: 21:50
 */

namespace App\Common;


class Collection
{
    public static function reOrderByParent(\Illuminate\Support\Collection $collection, $parent_id = 0)
    {
        $data = [];

        foreach ($collection as $item) {
            if ($item->parent_id == $parent_id) {
                $item->childrens = self::reOrderByParent($collection, $item->id);

                $data[] = $item;
            }
        }

        return collect($data);
    }
}