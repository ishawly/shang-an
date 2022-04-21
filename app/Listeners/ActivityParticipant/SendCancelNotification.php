<?php

namespace App\Listeners\ActivityParticipant;

use App\Events\ActivityParticipant\ActivityParticipantCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendCancelNotification
{
    public function __construct()
    {
        //
    }

    public function handle(ActivityParticipantCancelled $event)
    {
        Log::info("用户取消加入活动", $event->participant->toArray());

    }
}
