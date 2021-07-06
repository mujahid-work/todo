<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CustomService;

class LoginController extends Controller
{
    public function validateLogin(Request $request)
    {
        CustomService::validateRequest('login', $request);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
            $data = Auth::user();
            return CustomService::returnSuccessResponse('login', $data, 200);
        } else {
            return CustomService::returnExceptionResponse('login', 401);
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
