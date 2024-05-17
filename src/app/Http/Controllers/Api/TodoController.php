<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function toggleCompletion(Request $request, Todo $todo)
    {
        $todo->completed = $request->completed;
        $todo->save();

        return response()->json($todo);
    }
}
