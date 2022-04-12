<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    protected function getDateTimeStr(?Carbon $dt)
    {
        return $dt ? $dt->toDateTimeString() : '';
    }
}
