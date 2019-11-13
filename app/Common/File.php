<?php
namespace App\Common;

/**
 * Class File
 * @package App\Common
 */
class File
{
    /**
     * @param $dir
     * @param int $mode
     * @param bool|true $recursive
     */
    public static function makeDirectory($dir, $mode = 0777, $recursive = true)
    {
        $old_umask = umask(0);
        mkdir($dir, $mode, $recursive);
        umask($old_umask);
    }


}