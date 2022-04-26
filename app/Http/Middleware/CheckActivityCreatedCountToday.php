<?php

namespace App\Http\Middleware;

use App\Contracts\ShangAn;
use App\Models\Activity;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActivityCreatedCountToday
{
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->user() || empty($request->user()->id))) {
            abort(Response::HTTP_UNAUTHORIZED, '请先登陆');
        }
        $userId   = $request->user()->id;
        $now      = Carbon::now();
        $dateFrom = $now->format('Y-m-d 00:00:00');
        $dateTo   = $now->format('Y-m-d 23:59:59');
        $count    = Activity::query()->where('created_by', $userId)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();
        if (ShangAn::ACTIVITY_CREATE_MAX_COUNT_TODAY < $count) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, sprintf('每天活动创建量不能超过%d条', ShangAn::ACTIVITY_CREATE_MAX_COUNT_TODAY));
        }

        return $next($request);
    }
}
