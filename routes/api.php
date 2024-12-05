<?php

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WordPressController;


use App\Http\Controllers\SearchController;

Route::get('/search', [SearchController::class, 'search']);


Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/authenticate', [AuthController::class, 'authenticate']); // روت احراز هویت


//Route::post('/sync-wordpress-data', [WordPressController::class, 'syncData']);
Route::post('/webhook', function (Request $request) {
    dd($request->all());
    // دریافت داده‌های ارسال شده از وردپرس
    $data = $request->all();

    // نمایش داده‌ها برای اطمینان از دریافت صحیح
    Log::info('Received data from WordPress webhook: ', $data);

    // بررسی داده‌ها و ذخیره یا بروزرسانی در دیتابیس لاراول
    $post = Equipment::updateOrCreate(
        ['id' => $data['id']], // اگر پست موجود باشد، بروزرسانی می‌شود
        [
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'],
            'date' => $data['date'],
        ]
    );

    return response()->json(['status' => 'success']);
});

// مثال: تعریف یک روت ساده برای API
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello, Worlddddddddddddd!']);
});

// اینجا می‌توانید روت‌های مربوط به API خود را تعریف کنید
