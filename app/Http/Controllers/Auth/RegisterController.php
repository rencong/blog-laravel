<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Model\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
//            'api_token' => str_random(60)
        ]);
    }

    public function apiRegister(Request $request)
    {
        try {
            $this->validate($request, [
                'name'     => 'required|string',
                'email'    => 'required|string',
                'password' => 'required|string',
//                'name' => 'required|string|max:255',
//                'email'    => 'required|string|email|max:255|unique:users',
//                'password' => 'required|string|min:6|confirmed',
            ]);
            $data = [
                'avatar'       => 'images/default-avatar.png',
                'confirm_code' => str_random(48),
                'api_token' => str_random(60)
            ];
            $user = User::create(array_merge($request->all(), $data));

            $view = 'email.register';
            $subject = '验证邮箱';
            $this->sendTo($view, $subject, $user, $data);
            return apiSuccess();
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }

    }


    /**
     * 发送邮件
     * @param $view
     * @param $subject
     * @param $user
     * @param array $data
     */
    public function sendTo($view, $subject, $user, $data = [])
    {
        Mail::send($view, $data, function ($message) use ($user, $subject) {
            $message->to($user->email)->subject($subject);
        });
    }
}
