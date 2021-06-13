<?php

namespace App\Listeners;

use App\Events\ParkUserAttached;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\EstimatedWaitTime;

class SendEstimatedWaitTime
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
     * @param  ParkUserAttached  $event
     * @return void
     */
    public function handle(ParkUserAttached $event)
    {
        $usersInQ = $event->parkUser->park->users()->get();

        foreach($usersInQ as $userInQ) {
            $userInQ->notify(new EstimatedWaitTime($event->parkUser->park));
        }
    }
}
