<?php
namespace App\Common\Adapter;

use App\Common\File;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log extends Logger
{
    public $config_name, $file_name, $path, $type;


    public function __construct($config_name, $specify = [])
    {
        $config = config('cms.logging.'.$config_name);
        if(!isset($config) || !isset($config['path'])) {
            throw new \Exception('Config "'.$config_name.'" must be set !');
        }

        $this->config_name = $config_name;
        $this->file_name    = isset($specify['file_name'])?$specify['file_name']:$config_name;
        $this->path         = isset($specify['path'])?$specify['path']:$config['path'];
        $this->type         = isset($specify['type']) ? $specify['type'] : $config['type'];
        $this->level        = isset($specify['level']) ? $specify['level'] : $config['level'];
        /* neu khong co thu muc thi tao moi*/
        if(!is_dir($this->path) )  File::makeDirectory($this->path);
        //
        $streamHandler = new StreamHandler($this->path . $this->getLogFile() . '.log', $this->level);

        parent::__construct($this->config_name, [$streamHandler]);
    }

    public function getLogFile() {

        switch($this->type) {
            case 'daily':
                $slug = (new \DateTime())->format('Y-m-d');
                break;
            case 'monthly':
                $slug = (new \DateTime())->format('Y-m');
                break;
            case 'yearly':
                $slug = (new \DateTime())->format('Y');

                break;
            default: $slug = '';break;
        }

        $name = ($this->file_name !='')?$this->file_name:$this->config_name;

        return $name.($slug!=''?'-'.$slug:'');
    }
}