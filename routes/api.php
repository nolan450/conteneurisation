<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{uid}/', [MovieController::class, 'show']);
Route::post('/movies', [MovieController::class, 'store']);
Route::put('/movies/{uid}', [MovieController::class, 'update']);
Route::delete('/movies/{uid}', [MovieController::class, 'destroy']);

Route::get('/categories/{output_format}', [CategoryController::class, 'index']);
Route::get('/category/{category}/{output_format}', [CategoryController::class, 'show']);
Route::post('/category/{output_format}', [CategoryController::class, 'store']);
Route::patch('/category/{category}/{output_format}', [CategoryController::class, 'update']);
Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

