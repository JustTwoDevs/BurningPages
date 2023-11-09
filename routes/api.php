<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\BookController;
use App\Http\Controllers\api\v1\AuthorController;
use App\Http\Controllers\api\v1\BookSagaController;
use App\Http\Controllers\api\v1\GenreController;

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

Route::apiResource([
    "v1/books" => BookController::class,
    "v1/authors" => AuthorController::class,
    "v1/booksagas" => BookSagaController::class,
    "v1/genres" => GenreController::class,
]);
