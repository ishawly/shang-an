<?php

namespace App\Models;

use App\Events\ActivityParticipant\ActivityParticipantCancelled;
use App\Events\ActivityParticipant\ActivityParticipated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity_id',
        'user_id',
        'remarks',
    ];

    protected $dispatchesEvents = [
        'created' => ActivityParticipated::class,
    ];

    protected static function booted()
    {
        parent::booted();
        static::deleted(function ($participant) {
            ActivityParticipantCancelled::dispatch($participant);
        });
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
