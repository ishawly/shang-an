<?php

namespace App\Listeners\ActivityParticipant;

use App\Events\ActivityParticipant\ActivityParticipated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendParticipateNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param ActivityParticipated $event
     *
     * @return void
     */
    public function handle(ActivityParticipated $event)
    {
        Log::info('用户加入到活动中来', $event->participant->toArray());

        // TODO::send wechat notification
    }
}
