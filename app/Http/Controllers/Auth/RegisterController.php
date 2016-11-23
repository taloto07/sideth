<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Notifications\WelcomeNewUser;


class RegisterController extends Controller
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
    protected $redirectTo = '/';

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
            'activate_token' => str_random(60),
        ]);
    }

    // override register
    public function register(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $user->notify(new WelcomeNewUser($user));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('register_status', 'Please check your email to activate your account!');
    }

    public function activate(Request $request){

        $activate_token = $request->token;

        $user = User::where('activate_token', $activate_token)
                ->where('activate', 0)
                ->get();

        if ( !$user->count() ){
            return redirect( $this->redirectTo )->withErrors([
                    'activation' => 'Oop! activation fialed! Please try again later.'
                ]);
        }

        $user = $user->first();
        $user->activate_token = '';
        $user->activate = 1;
        $user->save();

        $this->guard()->login($user);

        return redirect( $this->redirectTo )->with('activate_success', 'Congratulation! you have activated your account!');
        
    }
}
