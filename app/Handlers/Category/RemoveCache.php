<?php

namespace App\Handlers\Category;

use App\Events\CategoryWasChange;
use App\Models\AdminActivity;
use Queue;
class RemoveCache
{
    public function handle(CategoryWasChange $event)
    {

    }
}