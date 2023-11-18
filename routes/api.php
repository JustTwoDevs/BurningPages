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
    "v1/sagareviews" => BookSagaReviewController::class,
    "v1/reviewrates" => ReviewRateController::class,
    "v1/sagareviewrates" => SagaReviewRateController::class,
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
 * 5. Añadir una reseña a un libro 
 */
Route::get('v1/authors/{author}/books', [BookController::class, 'indexByAuthor']);
Route::get('v1/bookSagas/{bookSaga}/books', [BookController::class, 'indexByBookSaga']);
Route::post('v1/books/{book}/genres/{genre}', [BookController::class, 'addGenre']);
Route::delete('v1/books/{book}/genres/{genre}', [BookController::class, 'removeGenre']);
Route::post('v1/books/{book}/reviews/{review}', [BookController::class, 'addReview']);

/**
 * BookSagas
 * 1. Obtener todas las sagas de un autor
 * 2. Obtener todos las sagas asociadas a un libro
 * 3. Añadir un libro a una saga
 * 4. Remover un libro a una saga
 * 5. Añadir una reseña a una saga
 */
Route::get('v1/authors/{author}/bookSagas', [BookSagaController::class, 'indexByAuthor']);
Route::get('v1/books/{book}/bookSagas', [BookSagaController::class, 'indexByBook']);
Route::post('v1/bookSagas/{booksaga}/books/{book}', [BookSagaController::class, 'addBook']);
Route::delete('v1/bookSagas/{booksaga}/books/{book}', [BookSagaController::class, 'removeBook']);
Route::post('v1/bookSagas/{booksaga}/reviews/{review}', [BookSagaController::class, 'addReview']);



/**
 * Reseñas de un libro 
 * 1. Obtener todas las reseñas de un usuario 
 * 2. Obtener todos las reseñas de un libro
 * 3. Publicar una reseña - usuario registrado
 * 4. Ocultar una reseña - usuario administrador
 * 5. Publicar una reseña - usuario administrador
 * 6. Añadirle una calificacion a una reseña 
 */
Route::get('v1/users/{user}/reviews', [BookReviewController::class, 'indexByUser']);
Route::get('v1/books/{book}/reviews', [BookReviewController::class, 'indexByBook']);
Route::patch('v1/reviews/{review}/publish', [BookReviewController::class, 'publish']);
Route::patch('v1/reviews/{review}/hide', [BookReviewController::class, 'occult']);

Route::post('v1/reviews/{review}/reviewrates/{reviewRate}', [BookReviewController::class, 'addReviewRate']);

/**
 * Reseñas de una saga 
 *  1. Obtener todas las reseñas de una saga
 *  2. Publicar una reseña de una saga - usuario registrado  
 *  3. Ocultar una reseña - usuario administrador
 *  4. Publicar una reseña de una saga - usuario administrador  
 *  5. Añadirle una calificacion a una reseña de una saga
 */
Route::get('v1/bookSagas/{booksaga}/reviews', [BookSagaReviewController::class, 'indexByBookSaga']);
Route::patch('v1/sagaReviews/{review}/publish', [BookSagaReviewController::class, 'publish']);
Route::patch('v1/sagaReviews/{review}/hide', [BookSagaReviewController::class, 'occult']);

Route::post('v1/sagaReviews/{review}/sagareviewrates/{reviewRate}', [BookSagaReviewController::class, 'addReviewRate']);


/**
 * Solicitudes de aval 
 * 1. Obtener todas las solicitudes de aval de un usuario 
 * 2. Aprobar una solicitud de aval - usuario administrador
 * 3. Rechazar una solicitud de aval - usuario administrador
 */

Route::get('v1/users/{user}/backingrequests', [BackingRequestController::class, 'indexByUser']);
Route::patch('v1/backingrequests/{backingRequest}/approve', [BackingRequestController::class, 'approve']);
Route::patch('v1/backingrequests/{backingRequest}/reject', [BackingRequestController::class, 'reject']);

/**
 * Calificaciones de una reseña 
 * 1. Obtener todas las calificaciones de una reseña de un libro 
 * 2. Obtener todas las calificaciones de una reseña de una saga 
 */

 Route::get('v1/reviews/{review}/reviewRates', [ReviewRateController::class, 'indexByReview']);
 Route::get('v1/sagaReviews/{review}/reviewRates', [SagaReviewRateController::class, 'indexByReview']);

