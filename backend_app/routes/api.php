<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostVoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/posts', [PostController::class, 'getPostsByUser']);
});

Route::apiResource('posts', PostController::class);
Route::apiResource('posts.votes', PostVoteController::class)->only(['store', 'destroy', 'update']);
Route::apiResource('posts.comments', CommentController::class)->except('show');
Route::get('users/{user}/posts', [PostController::class, 'getPostsByUser']);
