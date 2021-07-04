<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Services\CustomService;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        CustomService::validateRequest('register', $request);
        $code = CustomService::generateVerificationCode();
        $is_created = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'verification_code' => $code,
            'password' => Hash::make($request->password)
        ]);
        if ($is_created) {
            CustomService::sendVerificationEmail($code, $request->email);
            $response = [
                'success' => ['Heads Up! Account created successfully. Please check your email for verification code.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Something went wrong. Please try again.']
            ]);
        }
    }

    public function verifyAccount(Request $request)
    {
        CustomService::validateRequest('verify-account', $request);
        $is_updated = User::where('verification_code', $request->code)
            ->update([
                'is_active' => 1,
                'verification_code' => null,
                'email_verified_at' => Carbon::now()
            ]);
        if ($is_updated) {
            $response = [
                'success' => ['Heads Up! Account verified successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Invalid verification code. Please try again with a valid one.']
            ]);
        }
    }
}
