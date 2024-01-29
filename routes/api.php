<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\EskulController;

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

Route::get('eskul', [EskulController::class, 'index'])->name('api.eskul');
Route::get('eskul/detail/{slug}', [EskulController::class, 'detail'])->name('api.eskul.detail');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
