<?php
namespace App\Common; 


class Cache
{
	
	const KEY_CLINGMESEARCH_CATEGORY = 'clingmesearch_category';
	const KEY_CLINGMECATEGORY_ITEM = 'clingmecategory_item';

	const KEY_CLINGMEADMIN_NOTIFICATION = 'clingmeadmin_notification';

    public static function core(){
		return cache()->store('memcached');
    }
	
}