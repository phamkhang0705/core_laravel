<?php
namespace App\Common\Adapter;

class FileSystem extends \Illuminate\Filesystem\Filesystem
{
    public function __construct()
    {

    }

    public function append($path, $data)
    {
        return file_put_contents($path, $data, FILE_APPEND);
    }
}