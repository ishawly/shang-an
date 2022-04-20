<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as Controller;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Activity;
use App\Models\Participant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParticipantController extends Controller
{
    public function store(StoreParticipantRequest $request, Activity $activity)
    {
        $participant = Participant::firstOrNew([
            'activity_id' => $activity->id,
            'user_id' => $request->user()->id,
        ]);

        return $this->update($request, $activity, $participant);
    }

    public function show(Activity $activity, Participant $participant)
    {
        $participant->load(['user', 'activity']);

        return $this->success(new ParticipantResource($participant));
    }

    public function update(UpdateParticipantRequest $request, Activity $activity, Participant $participant)
    {
        $participant->remarks = $request->validated('remarks');
        $participant->save();

        return $this->success(new ParticipantResource($participant));
    }

    public function destroy(Request $request, Activity $activity, Participant $participant)
    {
        if ($request->user()->id != $participant->user_id) {
            return $this->error('需活动参与人执行该操作', Response::HTTP_FORBIDDEN);
        }

        $participant->delete();

        return $this->successNoContent();
    }
}
