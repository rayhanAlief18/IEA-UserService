<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [UserController::class, 'register']);
// Route::get('/getUser', [UserController::class, 'index']);
Route::get('/getUser', [UserController::class, 'index']);

Route::get('/getUser/{id}', [UserController::class, 'getUserById']);

Route::post('/hasura/get-user', [UserController::class, 'getUserByIdHasura']);


Route::get('/user/{id}/order',[UserController::class,'historyOrderUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// docker

