<?php
namespace App\Common\Adapter;

/**
 * @method static DB beginTransaction()
 * @method static DB rollBack()
 * @method static DB commit()
 * @method where($key, $operator, $condition) static DB where()
 * @method orderBy($field, $type)
 */
class DB extends \Illuminate\Support\Facades\DB
{

}