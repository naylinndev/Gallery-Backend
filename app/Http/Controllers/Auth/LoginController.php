<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use View;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        // show the form
        return view('backend.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function doLogin(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = Validator::make($request->only('email', 'password'), [
            'email'    => 'required', // make sure the email is an actual email
            'password' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
        ]);

        if ($rules->fails()) {
            return Response::json([
                'status' => 'fail',
                'msg'    => implode(",", $rules->messages()->all()),
            ]);
        } else {
            $userdata = $request->only('email', 'password');

            // attempt to do the login
            if (Auth::attempt($userdata)) {

                return Response::json(array(
                    'status' => 'success',
                ));

            } else {

                // validation not successful, send back to form
                return Response::json(array(
                    'status' => 'fail',
                    'msg'    => 'Invalid Email or Password',
                ));

            }
        }

    }

}
