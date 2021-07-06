<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            return CustomService::returnSuccessResponse('register', null, 201);
        } else {
            return CustomService::returnExceptionResponse('something-went-wrong', 403);
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
            return CustomService::returnSuccessResponse('verify-account', null, 200);
        } else {
            return CustomService::returnExceptionResponse('something-went-wrong', 403);
        }
    }
}
