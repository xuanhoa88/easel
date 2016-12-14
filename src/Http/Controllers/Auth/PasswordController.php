<?php
/**
 * Created by PhpStorm.
 * User: talv
 * Date: 13/12/16
 * Time: 16:24.
 */

namespace Canvas\Http\Controllers\Auth;


use \Auth;
use Canvas\Http\Controllers\Controller;
use \Session;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password'     => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $guard = Auth::guard();

        if (! $guard->validate($request->only('password'))) {
            return back()->withErrors(trans('auth.failed'));
        }

        $user = $guard->user();
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        Session::set('_passwordUpdate', trans('messages.update_success', ['entity' => 'Your password']));

        return back();
    }
}
