<?php

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
use App\Http\Controllers\api\v1\ReviewController;
use App\Http\Controllers\api\v1\BookReviewRateController;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware('can:superAdmin')->group(function () {
        Route::get("v1/users", [UserController::class, 'index']);
        Route::get("v1/users/{userId}", [UserController::class, 'show']);
        Route::put("v1/users/{userId}", [UserController::class, 'update']);
        Route::get("v1/adminUsers", [AdminUserController::class, 'index']);
        Route::get("v1/adminUsers/{userId}", [AdminUserController::class, 'show']);
        Route::post("v1/adminUsers", [AdminUserController::class, 'store']);
        Route::put("v1/adminUsers/{userId}", [AdminUserController::class, 'update']);
        Route::delete("v1/adminUsers/{userId}", [AdminUserController::class, 'destroy']);
    });


    // Rutas a las que solo puede acceder el usuario registrado.
    Route::middleware('can:registeredUser')->group(function () {

        /**
         * MyProfile
         */
        Route::get("v1/myprofile", [RegisteredUserController::class, 'getMyProfile']);
        Route::put("v1/myprofile", [RegisteredUserController::class, 'updateMyProfile']);
        Route::put("v1/myprofile/password", [RegisteredUserController::class, 'updateMyPassword']);
        Route::delete("v1/myprofile", [RegisteredUserController::class, 'deleteMyProfile']);

        /**
         * reviews
         * Rutas de usuario registrado:
         * 1. Obtener todas mis reseñas
         * 2. Crear una reseña de un libro
         * 3. crear una reseña de una saga
         * 5. Publicar una reseña
         * 6. Poner en borrador una reseña
         * 7. Eliminar una reseña
         * 8. Obtener una reseña por el id
         */
        Route::get('v1/myprofile/reviews', [ReviewController::class, 'indexMyReviews']);
        Route::post('v1/books/{bookId}/bookReviews', [BookReviewController::class, 'store']);
        Route::post('v1/bookSagas/{bookSaga}/bookSagaReviews', [BookSagaReviewController::class, 'store']);
        Route::patch('v1/reviews/{review}/public', [ReviewController::class, 'publishRegistered']);
        Route::patch('v1/reviews/{review}/draft', [ReviewController::class, 'draft']);
        Route::delete('v1/reviews/{review}', [ReviewController::class, 'destroy']);
        Route::get('v1/reviews/{review}/mine', [ReviewController::class, 'showRegistered']);
        Route::put('v1/reviews/{review}', [ReviewController::class, 'update']);

        /**
         * BackingRequests
         * Rutas de usuario registrado:
         * 1. Crear una solicitud de aval
         * 2. Obtener todas mis solicitudes de aval
         */
        Route::post('v1/myprofile/backingRequests', [BackingRequestController::class, 'store']);
        Route::get('v1/myprofile/backingRequests', [BackingRequestController::class, 'indexByProfile']);

        /**
         * ReviewRates
         * 1. crear una calificacion a una reseña de un libro
         * 2. crear una calificacion a una reseña de una saga
         * 3. actualizar una calificacion a una reseña
         * 4. ver todas mis calificaciones
         * 5. eliminar una calificacion a una reseña
         *
         */

        Route::post('v1/bookReviews/{review}/reviewRates', [BookReviewRateController::class, 'store']);
        Route::post('v1/bookSagaReviews/{review}/reviewRates', [SagaReviewRateController::class, 'store']);
        Route::put('v1/reviewRates/{reviewRate}', [ReviewRateController::class, 'update']);
        Route::get('v1/myprofile/reviewRates', [ReviewRateController::class, 'indexMyReviewRates']);
        Route::delete('v1/reviewRates/{reviewRate}', [ReviewRateController::class, 'destroy']);
    });

    // Rutas a las que puede acceder el usuario administrador y el Admin.
    Route::middleware('can:superAdminOrAdminUser')->group(function () {

        /**
         * registeredUsers
         */
        Route::get("v1/registeredUsers", [RegisteredUserController::class, 'index']);
        Route::get("v1/registeredUsers/{userId}", [RegisteredUserController::class, 'show']);
        Route::put("v1/registeredUsers/{userId}", [RegisteredUserController::class, 'update']);
        Route::delete("v1/registeredUsers/{userId}", [RegisteredUserController::class, 'destroy']);

        /**
         * Authors
         */
        Route::apiResource('v1/authors', AuthorController::class)->except(['index', 'show']);
        Route::post('v1/authors/{author}/books/{book}', [AuthorController::class, 'addBook']);
        Route::delete('v1/authors/{author}/books/{book}', [AuthorController::class, 'removeBook']);

        /**
         * Books
         * 1. Añadir un genero a un libro.
         * 2. Remover un genero a un libro.
         */
        Route::apiResource('v1/books', BookController::class)->except(['index', 'show']);
        Route::post('v1/books/{book}/genres/{genre}', [BookController::class, 'addGenre']);
        Route::delete('v1/books/{book}/genres/{genre}', [BookController::class, 'removeGenre']);

        /**
         * BookSagas
         * 1. Añadir un libro a una saga.
         * 2. Remover un libro a una saga.
         */
        Route::apiResource('v1/bookSagas', BookSagaController::class)->except(['index', 'show']);
        Route::post('v1/bookSagas/{booksaga}/books/{book}', [BookSagaController::class, 'addBook']);
        Route::delete('v1/bookSagas/{booksaga}/books/{book}', [BookSagaController::class, 'removeBook']);

        /**
         * Genres
         */
        Route::apiResource('v1/genres', GenreController::class)->except(['index']);

        /**
         * reviews
         * Rutas de usuario administrativo
         * 1.  Obtener todas las reseñas (sin importar su estado)
         * 2. Obtener todas las reseñas de un usuario
         * 3. Obtener todas las reseñas de un libro
         * 4. Publicar una reseña de un libro
         * 5. Ocultar una reseña de un libro
         * 6. Obtener una reseña por su id
         * 7. Obtener todas las reseñas publicas
         */
        Route::get('v1/allReviews', [ReviewController::class, 'indexAdmin']);
        Route::get('v1/users/{user}/allReviews', [ReviewController::class, 'indexByUserAdmin']);
        Route::get('v1/books/{book}/allBookReviews', [BookReviewController::class, 'indexByBookRegistered']);
        Route::get('v1/bookSagas/{bookSaga}/allBookSagaReviews', [BookSagaReviewController::class, 'indexByBookSagaAdmin']);
        Route::get('v1/allReviews/{review}', [ReviewController::class, 'showAdmin']);
        Route::patch('v1/reviews/{review}/publish', [ReviewController::class, 'publishAdmin']);
        Route::patch('v1/reviews/{review}/hide', [ReviewController::class, 'occult']);
        Route::get('v1/reviews', [ReviewController::class, 'index']);



        /**
         * BackingRequests
         * Rutas de usuario administrativo:
         * 1. Obtener todas las solicitudes de aval de un usuario
         * 2. Obtener todas las solicitudes de aval
         * 3. Obtener una solicitud de aval por id
         * 2. Aprobar una solicitud de aval - usuario administrador
         * 3. Rechazar una solicitud de aval - usuario administrador
         */
        Route::get('v1/users/{user}/backingRequests', [BackingRequestController::class, 'indexByUser']);
        Route::get('v1/backingRequests', [BackingRequestController::class, 'index']);
        Route::get('v1/backingRequests/{backingRequest}', [BackingRequestController::class, 'show']);
        Route::patch('v1/backingRequests/{backingRequest}/approve', [BackingRequestController::class, 'approve']);
        Route::patch('v1/backingRequests/{backingRequest}/reject', [BackingRequestController::class, 'reject']);
    });

    // Rutas a las que puede acceder cualquier usuario autenticado.
    Route::post("v1/logout", [AuthController::class, 'logout']);
});

/**
 * Rutas Publicas
 */

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

// Route::apiResources([
//     "v1/books" => BookController::class,
//     "v1/authors" => AuthorController::class,
//     "v1/bookSagas" => BookSagaController::class,
//     "v1/genres" => GenreController::class,
// ]);
Route::apiResource("v1/books", BookController::class)->only(['index', 'show']);
Route::apiResource("v1/authors", AuthorController::class)->only(['index', 'show']);
Route::apiResource("v1/bookSagas", BookSagaController::class)->only(['index', 'show']);
Route::get("v1/genres", [GenreController::class, 'index']);


/**
 * Usuarios
 * 1. Obtener todos los usuarios
 * 2. Obtener un usuario
 * 5. Registrar un usuario
 * 6. Iniciar sesión
 */
Route::get("v1/profiles", [RegisteredUserController::class, 'getProfiles']);
Route::get("v1/profiles/{userId}", [RegisteredUserController::class, 'getProfile']);
Route::post("v1/register", [RegisteredUserController::class, 'store']);
Route::post("v1/login", [AuthController::class, 'login']);

/**
 * Authors
 * 1. Obtener todos los autores asociados a un libro
 * 2. Obtener todos los autores asociados a una saga
 */
Route::get('v1/books/{book}/authors', [AuthorController::class, 'indexByBook']);
Route::get('v1/bookSagas/{bookSaga}/authors', [AuthorController::class, 'indexByBookSaga']);

/**
 * Books
 * 1. Obtener todos los libros de un autor
 * 2. Obtener todos los libros de una saga
 */
Route::get('v1/authors/{author}/books', [BookController::class, 'indexByAuthor']);
Route::get('v1/bookSagas/{bookSaga}/books', [BookController::class, 'indexByBookSaga']);

/**
 * BookSagas
 * 1. Obtener todas las sagas de un autor
 * 2. Obtener todos las sagas asociadas a un libro
 */
Route::get('v1/authors/{author}/bookSagas', [BookSagaController::class, 'indexByAuthor']);
Route::get('v1/books/{book}/bookSagas', [BookSagaController::class, 'indexByBook']);


/**
 * Reseñas de un libro
 *
 * Rutas publicas:
 * 2. Obtener todas las reseñas de un libro
 * 3. Obtener todas las reseñas que estén publicadas
 * 4. Obtener una reseña publica por id
 */
Route::get('v1/users/{user}/reviews', [ReviewController::class, 'indexByUser']);
Route::get('v1/books/{book}/bookReviews', [BookReviewController::class, 'indexByBook']);
Route::get('v1/bookSagas/{bookSaga}/bookSagaReviews', [BookSagaReviewController::class, 'indexByBookSaga']);
Route::get('v1/reviews/{review}', [ReviewController::class, 'show']);
Route::get('v1/reviews', [BookReviewController::class, 'index']);

/**
 * Calificaciones de una reseña
 * Rutas publicas
 * ver una calificacion especifica
 * ver las calificaciones de una reseña de un libro
 * ver las calificaciones de una reseña de una saga
 */
Route::get('v1/reviewRates/{reviewRate}', [ReviewRateController::class, 'show']);
Route::get('v1/bookReviews/{review}/reviewRates', [BookReviewRateController::class, 'indexByReview']);
Route::get('v1/bookSagaReviews/{review}/reviewRates', [SagaReviewRateController::class, 'indexByReview']);

/**
 *  Obtener todas las nacionalidades
 */
Route::get('v1/nationalities', function () {
    return Nationality::all();
});

Route::post('v1/images', function (Request $request) {
    $path = $request->file('cover')->store('public');
    $path = str_replace('public/', '', $path);
    $url = url('storage/', $path);
    return response()->json(['image_path' => $path]);
});

Route::get('v1/images/{imageId}', function (string $imageId) {
    if (!Storage::disk('public')->exists($imageId)) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    $file = Storage::disk('public')->get($imageId);
    $filePath = storage_path('app/public/' . $imageId);
    $mimeType = File::mimeType($filePath);
    return response($file, 200)->header('Content-Type', $mimeType);
});
