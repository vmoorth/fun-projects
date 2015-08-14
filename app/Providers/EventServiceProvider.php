<?php

namespace App\Providers;
use App\Events\OrderPlaced;
use App\Listeners\EmailOrderPlaced;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

     protected $listen = [
    'App\Events\OrderPlaced' => [
        'App\Listeners\EmailOrderPlaced',
    ],
];

     public function boot(DispatcherContract $events)
    {
        parent::boot($events);
        Event::listen('App\Events\OrderPlaced',
                    'App\Listeners\EmailOrderPlaced');
    }
}
