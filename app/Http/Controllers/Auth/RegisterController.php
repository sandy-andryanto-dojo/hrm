<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User;
use App\Models\Auth\UserConfirm;
use App\Models\Auth\UserProfile;
use App\Core\Controllers\AppController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;
use App\Mail\Register;

class RegisterController extends AppController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
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
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'criteria' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $confirm = \App::environment('production', 'staging') ? 0 : 1;

        $post = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_confirm'=>$confirm
        ];

        $user = User::create($post);
        $user->assignRole("User");
        $token = base64_encode(strtolower($user->email.'.'.str_random(40)));

        UserConfirm::Create([
            'user_id'=>$user->id,
            'token'=>$token
        ]);

        UserProfile::Create(['user_id'=>$user->id]);

        if($this->is_connected()){
            Mail::to($data['email'])->send(new Register($user, $token));
        }
        
        return $user;
    }

    protected function registered(Request $request, $user) {
        $this->guard()->logout();
        $env = \App::environment('production', 'staging') ? 0 : 1;
        $message  = null;
        if($env == 1){
            $message = '<br><br>Silahkan anda mengkonfirmasi akun yang sudah dibuat. sistem kita telah mengirim tautan verifikasi pada alamat email anda, silahkan periksa e-mail anda.';
        }else{
            $message = '<br><br>Email anda sudah di verifikasi sebelumnya. Sekarang anda sudah bisa login.';
        }
        return redirect()->route('login')->with('info', $message);
    }

    public function confirmation($token) {
        $userConfirmed = UserConfirm::where('token', $token)->first();
        if (!is_null($userConfirmed)) {
           $user_id = $userConfirmed->user_id;
           $user = User::find($user_id);
           if(!$user->email_confirm){
                $user->email_confirm = 1;
                $user->save();
                $status = '<br><br>Email anda sudah di verifikasi. Sekarang anda sudah bisa login.';
           }else{
                $status = '<br><br>Email anda sudah di verifikasi sebelumnya. Sekarang anda sudah bisa login.';  
           }
        } else {
            return redirect()->route('login')->with('warning', 'Mohon maaf email anda tidak dapat di identifikasi');
        }
        return redirect()->route('login')->with('info', $status);
    }

    private function is_connected($sCheckHost = 'www.google.com') {
        return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
    }
}
