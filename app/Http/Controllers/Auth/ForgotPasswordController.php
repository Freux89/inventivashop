<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    # send reset link in email or code to phone
    public function sendResetLinkEmail(Request $request)
    {
        if ($request->reset_with == "email") {
            # email
            $this->validateEmail($request);

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
        }

        # phone
        $phone = validatePhone($request->phone);
        $user = User::where('phone', $phone)->first();
        if (is_null($user)) {
            flash(localize('User not found with this phone number'))->error();
            return back()->withInput();
        }

        $user->verification_code = rand(100000, 999999);
        $user->save();

        (new VerificationController)->sendOtp($user->phone, $user->verification_code);
        return redirect()->route('forgotPw.resetByPhone');
    }

    # resetByPhone
    public function resetByPhone()
    {
        return view('auth.passwords.setNewPwByPhone');
    }

    # updatePw
    public function updatePw(Request $request)
    {
        $user = User::where('verification_code', $request->verification_code)->first();
        if (is_null($user)) {
            flash(localize('User not found with this phone number'))->error();
            return back()->withInput();
        }

        $request->validate(
            [
                'password' => 'required|confirmed|min:6'
            ]
        );

        $user->password = Hash::make($request->password);
        $user->save();
        flash(localize('Password updated successfully, please login to continue'))->success();
        return redirect()->route('login');
    }
}
