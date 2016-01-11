<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\Api\apiController as apiController;
class EventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(SomeEvent $event)
    {
        //
    }
    public function onUserLogin($event) {
        $updatetable = new apiController();
        $updatetable->updateAccounts();
    }

    public function onUserLogout($event) {}

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            'auth.login',
            'App\Listeners\EventListener@onUserLogin'
        );
        $events->listen(
            'auth.logout',
            'App\Listeners\EventListener@onUserLogout'
        );
    }
}
