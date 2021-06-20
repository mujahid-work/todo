<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;
use Illuminate\Validation\ValidationException;

class ToDoController extends Controller
{
    public function index()
    {
        $data = ToDo::paginate(10);
        return response()->json($data);
    }

    // public function fetchUserTodoList($user_id){

    // }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);
        $is_created = ToDo::create($request->all());
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
        $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);
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
