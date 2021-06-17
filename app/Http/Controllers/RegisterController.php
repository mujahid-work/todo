<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $is_created = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($is_created) {
            $response = [
                'user' => $is_created,
                'success' => ['Heads Up! Account created successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Something went wrong. Please try again.']
            ]);
        }
    }
}
