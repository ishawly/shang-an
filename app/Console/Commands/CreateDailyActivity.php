<?php

namespace App\Console\Commands;

use App\Services\ActivityService;
use Illuminate\Console\Command;

class CreateDailyActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:create-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create daily activity';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ActivityService $activityService)
    {
        $activityService->createDailyActivity();

        return 0;
    }
}
