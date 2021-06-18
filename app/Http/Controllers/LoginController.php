<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function validateLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
            $response = [
                'user' => Auth::user(),
                'success' => ['Heads Up! User logged in successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Login failed please try again with valid credentials.']
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
