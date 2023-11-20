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
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\RegisteredUserController;
use App\Http\Controllers\api\v1\AdminUserController;
use App\Http\Controllers\api\v1\AuthController;

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

/*
 * Rutas de usuarios.
 */


// Rutas a las que solo puede acceder el admin.
Route::get("v1/users", [UserController::class, 'index']);
Route::get("v1/users/{userId}", [UserController::class, 'show']);
Route::put("v1/users/{userId}", [UserController::class, 'update']);
Route::get("v1/adminUsers", [AdminUserController::class, 'index']);
Route::get("v1/adminUsers/{userId}", [AdminUserController::class, 'show']);
Route::post("v1/adminUsers", [AdminUserController::class, 'store']);
Route::put("v1/adminUsers/{userId}", [AdminUserController::class, 'update']);
Route::delete("v1/adminUsers/{userId}", [AdminUserController::class, 'destroy']);

// Rutas publicas.
Route::get("v1/profiles", [RegisteredUserController::class, 'getProfiles']);
Route::get("v1/profiles/{userId}", [RegisteredUserController::class, 'getProfile']);
Route::post("v1/register", [RegisteredUserController::class, 'store']);
Route::post("v1/login", [AuthController::class, 'login']);

// Rutas a las que solo puede acceder el usuario registrado.
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("v1/myprofile", [RegisteredUserController::class, 'getMyProfile']);
    Route::put("v1/myprofile", [RegisteredUserController::class, 'updateMyProfile']);
    Route::put("v1/myprofile/password", [RegisteredUserController::class, 'updateMyPassword']);
    Route::delete("v1/myprofile", [RegisteredUserController::class, 'deleteMyProfile']);
});

// Rutas a las que puede acceder el usuario administrador.
Route::get("v1/registeredUsers", [RegisteredUserController::class, 'index']);
Route::get("v1/registeredUsers/{userId}", [RegisteredUserController::class, 'show']);
Route::put("v1/registeredUsers/{userId}", [RegisteredUserController::class, 'update']);
Route::delete("v1/registeredUsers/{userId}", [RegisteredUserController::class, 'destroy']);

// Rutas a las que puede acceder cualquier usuario.
Route::post("v1/logout", [AuthController::class, 'logout']);


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
    "v1/backingRequests" => BackingRequestController::class,
    "v1/bookReviews" => BookReviewController::class,
    "v1/bookSagaReviews" => BookSagaReviewController::class,
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
 */
Route::get('v1/users/{user}/bookReviews', [BookReviewController::class, 'indexByUser']);
Route::get('v1/books/{book}/bookReviews', [BookReviewController::class, 'indexByBook']);
Route::patch('v1/bookReviews/{review}/publish', [BookReviewController::class, 'publish']);
Route::patch('v1/bookReviews/{review}/hide', [BookReviewController::class, 'occult']);

/**
 * Reseñas de una saga
 *  1. Obtener todas las reseñas de una saga
 *  2. Publicar una reseña de una saga - usuario registrado
 *  3. Ocultar una reseña - usuario administrador
 *  4. Publicar una reseña de una saga - usuario administrador
 */
Route::get('v1/bookSagas/{booksaga}/reviews', [BookSagaReviewController::class, 'indexByBookSaga']);
Route::patch('v1/bookSagaReviews/{review}/publish', [BookSagaReviewController::class, 'publish']);
Route::patch('v1/bookSagaReviews/{review}/hide', [BookSagaReviewController::class, 'occult']);



/**
 * Solicitudes de aval
 * 1. Obtener todas las solicitudes de aval de un usuario
 * 2. Aprobar una solicitud de aval - usuario administrador
 * 3. Rechazar una solicitud de aval - usuario administrador
 */

Route::get('v1/users/{user}/backingRequests', [BackingRequestController::class, 'indexByUser']);
Route::patch('v1/backingRequests/{backingRequest}/approve', [BackingRequestController::class, 'approve']);
Route::patch('v1/backingRequests/{backingRequest}/reject', [BackingRequestController::class, 'reject']);

/**
 * Calificaciones de una reseña
 * 1. Obtener todas las calificaciones de una reseña de un libro
 * 2. Obtener todas las calificaciones de una reseña de una saga
 */

Route::get('v1/bookReviews/{review}/reviewRates', [ReviewRateController::class, 'indexByReview']);
Route::get('v1/bookSagaReviews/{review}/reviewRates', [SagaReviewRateController::class, 'indexByReview']);
