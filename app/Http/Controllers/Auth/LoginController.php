<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helper\LdapHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

require_once app_path('Helper/constants.php');

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
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request, LdapHelper $ldapHelper)
    {
        // dd(Hash::make("password"));
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);


        session_start();
        $_SESSION['username'] = "admin";

        // create a session username for ojs users ?

        if ($request->username == "admin" || $request->username ==  "abrahsisay" || $request->username ==  "doctor" || $request->username ==  "reception" || $request->username ==  "pharmacy" || $request->username ==  "pharmacy" || $request->username ==  "store") {
            if (Auth::attempt($credentials)) {
                return redirect(route('dashboard'));
            } else {
                return Redirect::back()->withErrors(['msg' => 'Invalid Credentials']);
            }
        } else {
            $auth = $ldapHelper->authenticate($credentials);
            //dd($auth);
            if ($auth) {

                Auth::login($auth);
                session()->regenerate();
                if (Auth::user()->hasRole('doctor')) {
                    return redirect(route('encounters.index'));
                }
                return redirect(route('dashboard'));
            } else {
                return Redirect::back()->withErrors(['msg' => 'Invalid Credentials']);
            }
        }
    }
}
