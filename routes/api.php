<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\BookController;
use App\Http\Controllers\api\v1\AuthorController;
use App\Http\Controllers\api\v1\BookSagaController;
use App\Http\Controllers\api\v1\GenreController;
use App\Http\Controllers\api\v1\BookReviewController;
use App\Http\Controllers\api\v1\BookSagaReviewController;
use App\Http\Controllers\api\v1\ReviewRateController;
use App\Http\Controllers\api\v1\SagaReviewRateController;
use App\Http\Controllers\api\v1\BackingRequestController;

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

/**
 * Filtros:
 * 1. Generos -> Books, BookSagas, Authors
 * 2. Rango de fecha de publicación -> Books
 * 3. Idioma original -> Books
 * 4. Titulo -> Books, BookSagas
 * 5. Name, lastname, pseudonym -> Authors
 * 6. Nacionalidad -> Authors
 * 7. Autor -> Books, BookSagas
 *
 * Ordenar por:
 * 1. Valoración de las reseñas en burningmeter y readerScore -> Books, BookSagas
 * 2. Fecha de publicación -> Books
 * 3. Nombre completo -> Authors
 */

// CRUD de todos los modelos
Route::apiResources([
    "v1/books" => BookController::class,
    "v1/authors" => AuthorController::class,
    "v1/bookSagas" => BookSagaController::class,
    "v1/genres" => GenreController::class,
    "v1/backingrequests" => BackingRequestController::class,
    "v1/reviews" => BookReviewController::class,
    "v1/sagaReviews" => BookSagaReviewController::class,
    "v1/reviewRates" => ReviewRateController::class,
    "v1/sagaReviewRates" => SagaReviewRateController::class,
]);

/**
 * Authors
 * 1. Obtener todos los autores asociados a un libro
 * 2. Obtener todos los autores asociados a una saga
 * 3. Añadir un libro a un autor
 * 4. Remover un libro a un autor
 */
Route::get('v1/books/{book}/authors', [AuthorController::class, 'indexByBook']);
Route::get('v1/bookSagas/{bookSaga}/authors', [AuthorController::class, 'indexByBookSaga']);
Route::post('v1/authors/{author}/books/{book}', [AuthorController::class, 'addBook']);
Route::delete('v1/authors/{author}/books/{book}', [AuthorController::class, 'removeBook']);

/**
 * Books
 * 1. Obtener todos los libros de un autor
 * 2. Obtener todos los libros de una saga
 * 3. Añadir un genero a un libro
 * 4. Remover un genero a un libro
 */
Route::get('v1/authors/{author}/books', [BookController::class, 'indexByAuthor']);
Route::get('v1/bookSagas/{bookSaga}/books', [BookController::class, 'indexByBookSaga']);
Route::post('v1/books/{book}/genres/{genre}', [BookController::class, 'addGenre']);
Route::delete('v1/books/{book}/genres/{genre}', [BookController::class, 'removeGenre']);

/**
 * BookSagas
 * 1. Obtener todas las sagas de un autor
 * 2. Obtener todos las sagas asociadas a un libro
 * 3. Añadir un libro a una saga
 * 4. Remover un libro a una saga
 */
Route::get('v1/authors/{author}/bookSagas', [BookSagaController::class, 'indexByAuthor']);
Route::get('v1/books/{book}/bookSagas', [BookSagaController::class, 'indexByBook']);
Route::post('v1/bookSagas/{bookSaga}/books/{book}', [BookSagaController::class, 'addBook']);
Route::delete('v1/bookSagas/{bookSaga}/books/{book}', [BookSagaController::class, 'removeBook']);

/**
 * Reseñas
 * 1. Obtener todas las reseñas de un usuario
 * 2. Obtener todos las reseñas de un libro
 * 3. Obtener todas las reseñas de una saga
 */


/**
 * Solicitudes de aval
 * 1. Obtener todas las solicitudes de aval de un usuario
 */
