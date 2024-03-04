<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = \auth('api')->user();
    }

    public function index() {
        $logs = LogActivity::paginate(15);

        return response()->json([
            'message' => 'All activities',
            'logs' => $logs,
        ], 201);
    }
}
