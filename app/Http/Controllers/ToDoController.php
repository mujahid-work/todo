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
            $response = [
                'success' => ['Heads Up! Record added successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Something went wrong. Please try again.']
            ]);
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
            $response = [
                'success' => ['Heads Up! Record updated successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Something went wrong. Please try again.']
            ]);
        }
    }

    public function destroy($id)
    {
        $is_deleted = ToDo::destroy($id);
        if ($is_deleted) {
            $response = [
                'success' => ['Heads Up! Record deleted successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Something went wrong. Please try again.']
            ]);
        }
    }
}
