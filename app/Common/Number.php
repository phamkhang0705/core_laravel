<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/21/2016
 * Time: 6:28 AM
 */

namespace App\Common;


class Number
{
    public static function price($data)
    {
        return number_format($data, 0, '', '.');
    }
    public static function toString($data)
    {
        return number_format($data, 0, '', '.');
    }
}