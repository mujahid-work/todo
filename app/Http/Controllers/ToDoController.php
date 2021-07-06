<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Services\CustomService;

class ToDoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $data = ToDo::where('title', 'LIKE', "%{$request->keywords}%")
                ->where('user_id', '=', $user->id)
                ->paginate(9);
            return response()->json($data);
        }
        return false;
    }

    public function store(Request $request)
    {
        CustomService::validateRequest('create-todo', $request);
        $user = Auth::user();
        $is_created = ToDo::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user->id
        ]);
        if ($is_created) {
            return CustomService::returnSuccessResponse('create-todo', null, 201);
        } else {
            return CustomService::returnExceptionResponse('something-went-wrong', 403);
        }
    }

    public function show($id)
    {
        return ToDo::find($id);
    }

    public function update(Request $request, $id)
    {
        CustomService::validateRequest('update-todo', $request);
        $is_found = ToDo::find($id);
        if ($is_found) {
            $is_found->update($request->all());
            return CustomService::returnSuccessResponse('update-todo', null, 200);
        } else {
            return CustomService::returnExceptionResponse('something-went-wrong', 403);
        }
    }

    public function destroy($id)
    {
        $is_deleted = ToDo::destroy($id);
        if ($is_deleted) {
            return CustomService::returnSuccessResponse('delete-todo', null, 200);
        } else {
            return CustomService::returnExceptionResponse('something-went-wrong', 403);
        }
    }
}
