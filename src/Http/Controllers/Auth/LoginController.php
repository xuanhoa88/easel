<?php
/**
 * Created by PhpStorm.
 * User: talv
 * Date: 13/12/16
 * Time: 16:18.
 */

namespace Canvas\Http\Controllers\Auth;

use Session;
use Validator;
use Canvas\Helpers;
use Canvas\Models\User;
use Canvas\Models\Settings;
use Illuminate\Http\Request;
use Canvas\Helpers\CanvasHelper;
use Canvas\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('canvas::auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
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
     * During the login process, call the GitHub API and grab the latest
     * version of Canvas available and store it in the database. The
     * functionality is kept here so that the API Rate Limit will
     * be harder to reach.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, User $user)
    {
        $col = Settings::getByName('latest_release');
        empty($col) ? Settings::firstOrCreate(['setting_name' => 'latest_release', 'setting_value' => CanvasHelper::getLatestRelease()]) : Settings::where('setting_name', 'latest_release')->update(['setting_value' => Helpers::getLatestRelease()]);
        Session::set('_login', trans('messages.login', ['display_name' => $user->display_name]));

        return redirect()->intended($this->redirectPath());
    }
}
