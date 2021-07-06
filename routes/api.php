<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ToDoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public routes start
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'validateLogin']);
Route::post('/verify-account', [RegisterController::class, 'verifyAccount']);
//public routes end

//protected routes start
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('todo', ToDoController::class);
    Route::get('/logout', [LoginController::class, 'logout']);
});
//protected routes end
