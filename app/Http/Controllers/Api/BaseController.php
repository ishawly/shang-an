<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use ApiResponse;

    public const PAGE_SIZE = 15;

    protected function getQueryPageSize(Request $request): int
    {
        $size                                 = $request->get('size', self::PAGE_SIZE);
        ($size <= 0 || $size > 100) and $size = self::PAGE_SIZE;

        return $size;
    }
}
