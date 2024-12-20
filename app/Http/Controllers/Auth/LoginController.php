<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Corcel\Model\User as WordPressUser;
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
    protected $redirectTo = '/search';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function login(Request $request)
    {
        dd('1');
        // اعتبارسنجی اطلاعات ورود
        $credentials = $request->only('email', 'password');
       
        // جستجو در دیتابیس وردپرس
        $wordpressUser = WordPressUser::where('user_email', $credentials['email'])->first();
       // dd(password_verify($credentials['password'], $wordpressUser->user_pass));
        // بررسی صحت رمز عبور
       // if ($wordpressUser && password_verify($credentials['password'], $wordpressUser->user_pass)) {
            if ($wordpressUser ) {
            // ورود کاربر به لاراول
            $user = User::firstOrCreate(
                ['user_email' => $wordpressUser->user_email],
                ['user_login' => $wordpressUser->display_name]
            );
            //  dd( $user);
            // ورود به سیستم لاراول
           // Auth::login($user);
            //Auth::logout();

            return redirect()->intended('login'); // هدایت به صفحه بعد از ورود موفق
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }
}
