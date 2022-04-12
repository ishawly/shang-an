<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController  as Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $page = Activity::query()->paginate();

        return $this->success($page);
    }

    public function store(StoreActivityRequest $request)
    {
        $userId = $request->user()->id;
        $data = $request->validated();
        $data['created_by'] = $userId;
        $activity = Activity::create($data);

        return $this->success(new ActivityResource($activity));
    }

    public function show(Activity $activity)
    {
        //
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        //
    }

    public function destroy(Activity $activity)
    {
        //
    }
}
