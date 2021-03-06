<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $size = $this->getQueryPageSize($request);

        $topics = Topic::query()->paginate($size);
        $data   = new TopicCollection($topics);
        // return $data;
        return $this->success($data);
    }

    public function store(StoreTopicRequest $request)
    {
        $validated = $request->validated();
        $userId    = $request->user()->id;
        $topic     = Topic::query()->where('topic_name', $validated['topic_name'])
            ->where('created_by', $userId)->first();
        if ($topic) {
            return $this->error("{$validated['topic_name']}主题已存在", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data  = array_merge($validated, ['created_by' => $userId]);
        $topic = Topic::query()->create($data);

        return $this->success(new TopicResource($topic));
    }

    public function show(Topic $topic, Request $request)
    {
        $userId = $request->user()->id;
        if ($topic->created_by != $userId) {
            return $this->error('需主题创建人执行该操作', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->success(new TopicResource($topic));
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $data = $request->safe()->only(['topic_name', 'remarks']);
        $topic->update($data);

        return $this->success(new TopicResource($topic));
    }

    public function destroy(Topic $topic, Request $request)
    {
        $userId = $request->user()->id;
        if ($topic->created_by != $userId) {
            return $this->error('需主题创建人执行该操作', Response::HTTP_FORBIDDEN);
        }
        $topic->delete();

        return $this->successNoContent();
    }
}
