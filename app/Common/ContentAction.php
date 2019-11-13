<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/03/2018
 * Time: 08:38
 */

namespace App\Common;


/**
 * Class Content
 * @package App\Common
 */
class ContentAction
{
    const ADD = 'ADD';
    const EDIT = 'EDIT';
    const DELETE= 'DELETE';

    public static function getContentAction()
    {
        return [
            self::ADD => 'Tạo mới',
            self::EDIT => 'Cập nhật',
            self::DELETE => 'Xóa',
        ];
    }

    public static function getContentActionName($action)
    {
        $s = self::getContentAction();
        return isset($s[$action]) ? $s[$action] : '';
    }


}