<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
	    'App\Events\Event' => [
		    'App\Listeners\EventListener',
	    ],
//	    'App\Events\CategoryWasChange' => [
//		    'App\Handlers\Category\Logging',
//        ],
//	    'App\Events\UserWasChange' => [
//		    'App\Handlers\Logging\LoggingUser',
//	    ],
//	    'App\Events\CashoutWasChange' => [
//		    'App\Handlers\Logging\LoggingTransaction',
//        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
