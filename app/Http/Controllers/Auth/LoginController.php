<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Nwidart\Modules\Facades\Module;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }


    # social login redirection
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    # obtain the user information from social media.
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            if ($provider == 'twitter') {
                $user = Socialite::driver('twitter')->user();
            } else {
                $user = Socialite::driver($provider)->stateless()->user();
            }
        } catch (\Exception $e) {
            flash("Something Went wrong. Please try again.")->error();
            return redirect()->route('home');
        }

        //check if provider_id exist
        $existingUserByProviderId = User::where('provider_id', $user->id)->first();

        if ($existingUserByProviderId) {
            //proceed to login
            auth()->login($existingUserByProviderId, true);
        } else {
            //check if email exist
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                //update provider_id
                $existing_User = $existingUser;
                $existing_User->provider_id = $user->id;
                $existing_User->email_verified_at = date('Y-m-d Hms');
                $existing_User->email_or_otp_verified = 1;
                $existing_User->save();

                //proceed to login
                auth()->login($existing_User, true);
            } else {
                //create a new user
                $newUser = new User;
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->email_verified_at = date('Y-m-d Hms');
                $newUser->email_or_otp_verified = 1;
                $newUser->provider_id = $user->id;
                $newUser->save();

                //proceed to login
                auth()->login($newUser, true);
            }
        }

        return $this->redirectCustomer();
    }

    # validate login
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required_without:phone',
            'phone'    => 'required_without:email',
            'password' => 'required|string',
        ]);
    }

    # set credentials for phone/email login
    protected function credentials(Request $request)
    {
        if ($request->get('login_with') == "phone" && $request->get('phone') != null) {
            session(['login_with' => "phone"]);
            $phone =  validatePhone($request->get('phone'));
            return ['phone' => $phone, 'password' => $request->get('password')];
        } elseif ($request->get('email') != null) {
            session(['login_with' => "email"]);
            return $request->only($this->username(), 'password');
        }
    }

    # Where to redirect users after login.
    public function authenticated()
    {
        if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
            try {
                return redirect()->route('admin.dashboard');
            } catch (\Throwable $th) {
                return redirect()->route('logout');
            }
        } elseif (auth()->user()->user_type == 'vendor' || auth()->user()->user_type == 'vendor_staff') {

            flash(localize('Vendor panel is unavailable'))->error();
            return redirect()->route('logout');
        }

        return $this->redirectCustomer();
    }

    # redirect customer
    protected function redirectCustomer()
    {
        // set guest_user_id to user_id from carts
        if (isset($_COOKIE['guest_user_id'])) {
            $carts  = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])->get();
            $userId = auth()->user()->id;
            if ($carts) {
                foreach ($carts as $cart) {
                    $existInUserCart = Cart::where('user_id', $userId)->where('product_variation_id', $cart->product_variation_id)->first();
                    if (!is_null($existInUserCart)) {
                        $existInUserCart->qty += $cart->qty;
                        $existInUserCart->save();
                        $cart->delete();
                    } else {
                        $cart->user_id = $userId;
                        $cart->guest_user_id = null;
                        $cart->save();
                    }
                }
            }
        }

        if (session('link') != null) {
            return redirect(session('link'));
        } else {
            return redirect()->route('customers.dashboard');
        }
    }

    # Get the failed login response instance.  
    protected function sendFailedLoginResponse(Request $request)
    {
        flash(localize('Invalid login credentials.'))->error();
        return back()->withInput();
    }
}
