<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::post("logout", [AuthController::class, "logout"]);
Route::get("user", [AuthController::class, "user"]);

Route::resource("tweets", TweetController::class)->middleware("auth:api");

Route::post("users/{user}/follow", [UserController::class, "follow"])->middleware("auth:api");
Route::get("users", [UserController::class, "index"])->middleware("auth:api");

Route::get("profile/{user:name}", [ProfileController::class, "show"])->middleware("auth:api");
Route::post("profile/{user}", [ProfileController::class, "update"])->middleware("auth:api");