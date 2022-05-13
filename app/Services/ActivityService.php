<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;

class ActivityService
{
    public function getDailyActivity(Carbon $date = null): Activity|null
    {
        !$date and $date = Carbon::now();

        $dateFrom = Carbon::parse($date->format('Y-m-d 00:00:00'));
        $dateTo   = $dateFrom->clone()->addDay();

        return Activity::where('topic_id', Topic::ID_STUDY_TOGETHER)
            ->whereBetween('start_at', [$dateFrom, $dateTo])
            ->first();
    }

    public function createDailyActivity()
    {
        $activity = $this->getDailyActivity();
        if ($activity) {
            return;
        }

        Activity::create([
            'created_by' => User::ID_SYSTEM,
            'topic_id'   => Topic::ID_STUDY_TOGETHER,
            'start_at'   => Carbon::parse('19:30:00'),
            'end_at'     => Carbon::parse('20:30:00'),
            'remarks'    => Inspiring::quote() . substr(0, 500),
        ]);
    }
}
