<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\LoginLog;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Obtener la IP del cliente
     *
     * @param  Request  $request
     * @return string
     */
    protected function getClientIp(Request $request)
    {
        if (!empty($request->server('HTTP_CLIENT_IP'))) {
            $ip = $request->server('HTTP_CLIENT_IP');
        } elseif (!empty($request->server('HTTP_X_FORWARDED_FOR'))) {
            $ip = $request->server('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $request->server('REMOTE_ADDR');
        }
        return $ip;
    }

    /**
     * Registrar el login del usuario
     *
     * @param  Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function authenticated(Request $request, User $user)
    {
        // Registrar el login en login_logs
        LoginLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'ip_address' => $this->getClientIp($request),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
        ]);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Registrar el logout y cerrar sesión
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $user = \Auth::user();

        if ($user) {
            LoginLog::create([
                'user_id'    => $user->id,
                'action'     => 'logout',
                'ip_address' => $this->getClientIp($request),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
        }

        \Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
