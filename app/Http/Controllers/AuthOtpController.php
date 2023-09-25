<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthOtpController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);

        $verificationCode = $this->generateOtp($request->email);

        return response([
            'user_id' => $verificationCode->user_id,
            'otp' => $verificationCode->otp,
            'message' => 'Your one time password',
            'success' => true,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        $verificationCode   = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            throw new \Exception('Your OTP is not correct');
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            throw new \Exception('Your OTP is expired');
        }

        $user = User::whereId($request->user_id)->first();

        if(!$user){
            throw new \Exception('Your Otp is not correct');
        }

        $verificationCode->update([
            'expire_at' => Carbon::now()
        ]);

        Auth::login($user);

        return response([
            'message' => 'Logged in successfully with otp!',
            'success' => true
        ]);
    }


    public function generateOtp($email)
    {
        $user = User::where('email', $email)->first();

        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }
}
