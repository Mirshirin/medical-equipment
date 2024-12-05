<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User; // مدل کاربر لاراول
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Http; // برای ارسال درخواست HTTP به وردپرس

class AuthController extends Controller
{
    /**
     * احراز هویت با استفاده از توکن JWT که از وردپرس دریافت می‌شود.
     */
    public function authenticate(Request $request)
    {
        try {
            // دریافت نام کاربری و رمز عبور از درخواست
            $username = $request->input('username');
            $password = $request->input('password');

            // ارسال درخواست به وردپرس برای دریافت توکن JWT
            $response = Http::post('http://equipment.ir/wp-json/jwt-auth/v1/token', [
                'username' => $username,
                'password' => $password
            ]);

            // بررسی موفقیت آمیز بودن دریافت توکن
            if ($response->failed()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // توکن JWT که از وردپرس دریافت شده است
            $jwt_token = $response->json()['token'];

            // احراز هویت در لاراول با استفاده از JWT
            $user = JWTAuth::authenticate($jwt_token);
            //$user = auth()->user();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // برگشت پاسخ موفق و اطلاعات کاربر
            return response()->json(['user' => $user, 'token' => $jwt_token]);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to authenticate token'], 500);
        }
    }
}
