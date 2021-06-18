<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

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
        $code = $this->generateVerificationCode();
        $is_created = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'verification_code' => $code,
            'password' => Hash::make($request->password)
        ]);
        if ($is_created) {
            $this->sendVerificationEmail($code, $request->email);
            $response = [
                'success' => ['Heads Up! Account created successfully.']
            ];
            return response()->json($response, 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['Oh Snap! Something went wrong. Please try again.']
            ]);
        }
    }

    public function sendVerificationEmail($code, $to)
    {
        $mail_data = [
            'pin_code' => $code,
            'body' => 'This is your account verfication code. Please use this pin code to verify your account.'
        ];
        Mail::to($to)->send(new VerificationEmail($mail_data));
        return true;
    }

    public function generateVerificationCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
            . Carbon::now()
            . $characters[rand(0, strlen($characters) - 1)];
        return str_shuffle($pin);
    }

    public function verifyAccount(Request $request)
    {
        $request->validate([
            'code' => ['required']
        ]);
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
