<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;

class AuthOtpController extends Controller
{
    public function generate(Request $request): void
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);

        $verificationCode = $this->generateOtp($request->email);

        $data = [
            'chat_id' => config('services.telegram-bot-api.chat_id'),
            'text' => 'Email: '. $request->email ."\nCode: " . $verificationCode,
        ];


        if ($verificationCode){
            $response = Telegram::bot('mybot')->sendMessage($data);
        }
//        $mail = Mail::to($request->email)->send(new OtpMail($verificationCode));
//        if ($mail){
//        return response('Check your email for otp!');
//        }
    }

    /**
     * @throws \Exception
     */
    public function loginWithOtp(Request $request): AuthResource
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

        $token = $user->createToken('api-token')->plainTextToken;
        return AuthResource::make(['user' => $user, 'token' => $token]);
    }


    public function generateOtp($email)
    {
        $user = User::where('email', $email)->first();

        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode->otp;
        }

        $otp = VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(1234, 9999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        return $otp->otp;
    }
}
