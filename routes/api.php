<?php

use App\Http\Controllers\BlogController;
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

Route::post('/blog', [BlogController::class, 'store']);
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{id}', [BlogController::class, 'show']);
Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->middleware('blogauthor');
Route::patch('/blog/{id}', [BlogController::class, 'update'])->middleware('blogauthor');
