<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public function apiLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]);
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where('email', $email)->where('password', $password)->first();
            if ($user) {
                if ($user->is_confirmed != 1) {
                    return apiError('邮箱没验证');
                }
                return apiSuccess($user);
            } else {
                return apiError('用户名或密码错误，请重新登录');
            }
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }

    /**
     * 验证邮件
     * @param $confirm_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmEmail($confirm_code)
    {
        $user = User::where('confirm_code', $confirm_code)->first();
        if (is_null($user)) {
            return "没找到";
        }

        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        $user->save();
        return "验证成功";
//        return redirect('user/login');
    }


}
