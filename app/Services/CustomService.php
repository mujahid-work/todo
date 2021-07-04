<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Carbon\Carbon;

class CustomService
{

    public static function sendVerificationEmail($code, $to)
    {
        $mail_data = [
            'pin_code' => $code,
            'body' => 'This is your account verfication code. Please use this pin code to verify your account.'
        ];
        Mail::to($to)->send(new VerificationEmail($mail_data));
        return true;
    }

    public static function generateVerificationCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
            . Carbon::now()
            . $characters[rand(0, strlen($characters) - 1)];
        return str_shuffle($pin);
    }

    public static function validateRequest($case, $request)
    {
        $rules = null;

        switch ($case) {
            case "login":
                $rules = [
                    'email' => ['required', 'email'],
                    'password' => ['required', 'min:6']
                ];
                break;
            case "register":
                $rules = [
                    'name' => ['required'],
                    'email' => ['required', 'email', 'unique:users'],
                    'password' => ['required', 'min:6', 'confirmed']
                ];
                break;
            case "verify-account":
                $rules = [
                    'code' => ['required']
                ];
                break;
            case "create-todo":
                $rules = [
                    'title' => ['required'],
                    'description' => ['required']
                ];
                break;
            case "update-todo":
                $rules = [
                    'title' => ['required'],
                    'description' => ['required']
                ];
                break;
        }

        if (empty($rules)) {
            return false;
        }

        $request->validate($rules);
    }
}
