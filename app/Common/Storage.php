<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 09/03/2018
 * Time: 09:39
 */

namespace App\Common;


use Illuminate\Http\UploadedFile;

class Storage
{
    /**
     * @var
     */
    public static $instance;

    /**
     * Storage constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Storage();
        }

        return self::$instance;
    }

    public function store($obj_id, $data, $options = [])
    {
        if (!$data instanceof UploadedFile) {
            return;
        }

        $file_name = isset($options['file_name']) ? time() . '_' . $options['file_name'] : time() . '_' . $obj_id . '.jpg';

        $base_dir = isset($options['base_dir']) ? $options['base_dir'] : 'default';

        $path = strtolower($base_dir) . Utility::getStoragePath($obj_id);

        $uri = $data->storeAs($path, $file_name);

        $link = env('STORAGE_URL') . '/' . $uri;

        return $link;
    }

    public function storeStatic($obj_id, $data, $options = [])
    {
        if (!$data instanceof UploadedFile) {
            return;
        }

        $file_name = isset($options['file_name']) ? $options['file_name'] : $obj_id . '.jpg';

        $base_dir = isset($options['base_dir']) ? $options['base_dir'] : 'default';

        $path = strtolower($base_dir);

        $data->storeAs($path, $file_name, 'static');

        return $file_name;
    }

}