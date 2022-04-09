<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    use ApiResponse;

    const PAGE_SIZE = 15;
}
