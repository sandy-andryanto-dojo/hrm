<?php

namespace App\Http\Controllers\Auth;

use App\Core\Controllers\AppController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends AppController
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request) {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL) ? $this->username() : 'username';
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    protected function authenticated(Request $request, $user) {
        if (!$user->email_confirm) {
            auth()->logout();
            return back()->with('warning', '<br><br>Silahkan anda mengkonfirmasi akun yang sudah dibuat. sistem kita telah mengirim tautan verifikasi pada alamat email anda, silahkan periksa e-mail anda.');
        }
        $previous_session = $user->session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }
        \Auth::user()->session_id = \Session::getId();
        \Auth::user()->save();
        return redirect()->intended($this->redirectPath());
    }
}
