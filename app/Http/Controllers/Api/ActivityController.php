<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController  as Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\Topic;
use App\Services\ActivityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('activity.store.check.count')->only('store');
    }

    public function index(Request $request)
    {
        $size   = $this->getQueryPageSize($request);
        $userId = $request->user()->id;

        $data = Activity::query()
            ->where('created_by', $userId)
            ->paginate($size);

        return $this->success(new ActivityCollection($data));
    }

    public function store(StoreActivityRequest $request)
    {
        $userId             = $request->user()->id;
        $data               = $request->validated();
        $data['created_by'] = $userId;
        $activity           = Activity::create($data);

        return $this->success(new ActivityResource($activity));
    }

    public function show(Activity $activity)
    {
        return $this->success(new ActivityResource($activity));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $data = $request->safe([
            'start_at',
            'end_at',
            'remarks',
        ]);

        $activity->update($data);

        return $this->success(new ActivityResource($activity));
    }

    public function destroy(Activity $activity, Request $request)
    {
        $userId = $request->user()->id;
        if ($activity->created_by != $userId) {
            return $this->error('需活动创建人执行该操作', Response::HTTP_FORBIDDEN);
        }
        $activity->delete();

        return $this->successNoContent();
    }

    public function getTodayActivity(ActivityService $activityService)
    {
        $activity = $activityService->getDailyActivity();

        if (!$activity) {
            return $this->error('未创建每日活动', Response::HTTP_NOT_FOUND);
        }

        $activity->load(['participants']);

        return $this->success(new ActivityResource($activity));
    }
}
