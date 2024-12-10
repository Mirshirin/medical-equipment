<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\WordPressController;
use App\Http\Controllers\Auth\LoginController;


Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fetch-and-save-data', [WordPressController::class, 'fetchAndSaveData']);
Route::get('/get-equipments', [WordPressController::class, 'getEquipments']);
Route::get('/search', function() {
    return view('search_form');  // نمایش فرم جستجو
});

Route::get('/search', [SearchController::class, 'search']);
Route::get('/search/index', [EquipmentController::class, 'indexDataInElasticsearch']);
Route::get('/search/test', [EquipmentController::class, 'testElasticSearchConnection']);

// روت برای دریافت تجهیزات از وردپرس
Route::get('/equipments/{termId}', [WordPressController::class, 'getSpecialty']);
Route::get('/equipments', [WordPressController::class, 'getEquipment']);

Route::get('export-equipments', [SearchController::class, 'export'])->name('export-equipments');
//Route::get('/dashboard/{id}', [DashboardController::class, 'showPost'])->middleware('auth');
//->middleware('role:Admin,کارشناس');
//Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');
//Route::post('/login', [LoginController::class, 'login']);
//Route::get('/login', [AuthController::class, 'login']);
Auth::routes();

