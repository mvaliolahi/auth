<?php

namespace Mvaliolahi\Auth\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mvaliolahi\Auth\Jobs\SendSMSJob;
use Mvaliolahi\Auth\Models\User;
use Mvaliolahi\Auth\Models\VerificationToken;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function loginForm()
    {
        if ($rules = config('auth_mobile.login_validations')) {
            $this->validate(request(), $rules);
        }

        if (auth()->check()) {
            return back();
        }

        // store last url intended.
        session(['url.intended' => url()->previous()]);

        return view('auth::pages.login');
    }

    /**
     * @return Redirect
     */
    public function sendToken()
    {
        $this->validate($request = request(), [
            'mobile' => 'required|numeric|digits:11',
        ]);

        // 1. Register user if not exists
        try {
            $user = User::where('mobile', $request->mobile)->firstOrFail();
        } catch (\Exception $exception) {
            $user = User::create([
                'mobile' => $request->mobile,
            ]);
        }

        // 2. Generate Verification Token For User.
        // 3. send token to mobile.
        $token = $user->generateVerificationToken()->token;

        if (app()->environment('production')) {
            dispatch(new SendSMSJob($request->mobile, $token));
        }

        // 4. redirect to verification token page.
        return redirect()->route('auth.verify.form', ['mobile' => $request->mobile]);
    }

    /**
     * @return View
     */
    public function verifyTokenForm($mobile)
    {
        if ($rules = config('auth_mobile.verify_validations')) {
            $this->validate(request(), $rules);
        }

        return view('auth::pages.verify', [
            'mobile' => $mobile,
        ]);
    }

    /**
     * @return Redirect
     */
    public function verify()
    {
        $this->validate($request = request(), [
            'token' => 'required',
            'mobile' => 'required|exists:users,mobile'
        ]);

        $token = VerificationToken::where('mobile', $request->mobile)
            ->where('token', $request->token)
            ->latest()
            ->first();

        // 1. Token not match or user not exists.
        if (is_null($token)) {
            return redirect()->route('auth.verify.form', ['mobile' => $request->mobile])->withErrors([
                'token' => trans('auth::messages.token_not_match')
            ]);
        }

        // 2. Token used before.
        if ($token->used) {
            return redirect()->route('auth.verify.form', ['mobile' => $request->mobile])->withErrors([
                'token' => trans('auth::messages.token_used')
            ]);
        }

        // 3. Check Token Expire
        if (Carbon::parse($token->created_at)->addSeconds(config('auth_mobile.token_expire'))->isPast()) {
            return redirect()->route('auth.verify.form', ['mobile' => $request->mobile])->withErrors([
                'token' => trans('auth::messages.token_expired')
            ]);
        }

        // 4. Token marked as used
        $token->markUsed();

        // 5. Token verified, User should be login and redirect.
        Auth::login($token->user);

        if (config('auth_mobile.redirect_to')) {
            return redirect(config('auth_mobile.redirect_to'));
        }

        if (config('auth_mobile.redirect_route')) {
            return redirect()->route(config('auth_mobile.redirect_route'));
        }

        // 6. redirect to "intended", last url before attempt to login.
        if ($intended = session("url.intended")) {
            session()->forget("url.intended");
            return redirect($intended);
        }

        return redirect('/');
    }


    /**
     * @return Redirect
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
