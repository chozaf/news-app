<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
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

Route::prefix('{lang?}')->middleware('locale')->group(function () {

    Route::apiResource('posts', PostController::class);

    Route::put('posts/{post}/tags/{tag}/attach', [PostController::class, 'attach'])
        ->where(['post' => '[0-9]{1,11}', 'tag' => '[0-9]{1,11}']);

    Route::put('posts/{post}/tags/{tag}/detach', [PostController::class, 'detach'])
        ->where(['post' => '[0-9]{1,11}', 'tag' => '[0-9]{1,11}']);


    Route::apiResource('tags', TagController::class);

    Route::put('tags/{tag}/posts/{post}/attach', [TagController::class, 'attach'])
        ->where(['post' => '[0-9]{1,11}', 'tag' => '[0-9]{1,11}']);

    Route::put('tags/{tag}/posts/{post}/detach', [TagController::class, 'detach'])
        ->where(['post' => '[0-9]{1,11}', 'tag' => '[0-9]{1,11}']);
});
