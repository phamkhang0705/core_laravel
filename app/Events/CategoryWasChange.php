<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use \Event;
class CategoryWasChange extends Event
{
    use SerializesModels;

    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
}
