<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\FrogotpasswordOTPsend\SendPasswordChangeConfirmation;
use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = $this->userInterface->findByColumn(['email' => $request->email]);

        if (! $user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $otp = rand(100000, 999999);

        $user->otp            = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        try {
            Notification::route('mail', $user->email)->notify(new SendPasswordChangeConfirmation($otp, $user->email));

            return response()->json(['message' => 'OTP has been sent to your email.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP. Please try again later.'], 500);
        }
    }

    public function otpVerifyFunction(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'otp']), [
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = $this->userInterface->findByColumn(['email' => $request->email]);

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully.'], 202);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->only(['password']), [
            'password' => 'required|min:4confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }

}
