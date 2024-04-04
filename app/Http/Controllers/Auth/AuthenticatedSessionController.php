<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GeoIp2\Database\Reader;
use Jenssegers\Agent\Facades\Agent;
use App\Helpers\ModuleHelper;
use Modules\LoginLog\Entities\LoginLog;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');

        return view('pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        // Store user information in the session
        // $request->session()->put('user_id', auth()->id());

        // $user = $request->user();

        // if (ModuleHelper::isModuleActive('LoginLog')) {
        //     // Create a new login log record
        //     LoginLog::create([
        //         'user_id' => $user->id,
        //         'location' => 'Indonesia', // Replace with the actual location data
        //         'device' => $this->getUserAgent(),
        //         'ip_address' => $request->getClientIp(),
        //         'login_time' => Carbon::now(),
        //         'description' => 'Current session', // Add the description here
        //         'status' => 'OK', // Add the status here
        //     ]);
        // }

        //asdasd

        $request->user()->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    // private function getUserAgent()
    // {
    //     $agent = new \Jenssegers\Agent\Agent;
    //     return $agent->browser() . ' - ' . $agent->platform();
    // }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
