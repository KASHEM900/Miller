<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User; 
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home'; // Normal login redirect

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    /**
     * Attempt login with MD5 password and reCAPTCHA
     */
    protected function attemptLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        // Find user by name + MD5 password
        $user = \App\User::where('name', $request->name)
                    ->where('password', md5($request->password))
                    ->first();

        if ($user) {
            // Login the user
            $this->guard()->login($user, $request->has('remember'));
            return true;
        }

        return false;
    }

    /**
     * Redirect after login based on atLoginDate (Bangladesh timezone)
     */
    protected function authenticated(Request $request, $user)
    {
        $tz = 'Asia/Dhaka'; // Bangladesh timezone

        if (is_null($user->atLoginDate)) {
            // Null → add 30 days and go to changepassword
            //$user->atLoginDate = Carbon::now($tz)->addDays(30);
            $user->atLoginDate = Carbon::now($tz);
            $user->save();
            return redirect('/loginchangepassword');
        }

        // Today date in Bangladesh timezone
        $today = Carbon::now($tz)->startOfDay();
        $loginDate = Carbon::parse($user->atLoginDate, $tz)->startOfDay()->addDays(30);
        //dd($loginDate);

        if ($loginDate->lt($today)) {
            // DB date < today → change password
            return redirect('/loginchangepassword');
        } else {
            // DB date >= today → go home
            return redirect('/home');
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}