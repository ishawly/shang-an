<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $topics = Topic::query()->paginate();

        return $this->success($topics);
    }

    public function store(StoreTopicRequest $request)
    {
        $validated = $request->validated();
        dd($validated);
        return $this->successMessage('ok');
    }

    public function show(Topic $topic)
    {
        //
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        //
    }

    public function destroy(Topic $topic)
    {
        //
    }
}
