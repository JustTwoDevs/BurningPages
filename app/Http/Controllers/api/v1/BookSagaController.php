<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookSaga;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\BookSagaStoreRequest;
use App\Http\Requests\api\v1\BookSagaUpdateRequest;
use App\Http\Requests\api\v1\AddBookStoreRequest;
use App\Http\Resources\BookSagaResource;

class BookSagaController extends Controller
{
    /**
     * Obtener todas las sagas.
     * Es posible filtrar por generos, nombre y autor.
     * Es posible ordenar por valoración de las reseñas en burningmeter y readerScore.
     * 
     * Ejemplos:
     * /bookSagas?genres=fantasy,romance
     * /bookSagas?name=Harry-Potter
     * /bookSagas?author=J.K-Rowling
     */
    public function index()
    {
        $query = request()->query();
        $bookSagas = BookSaga::query()->with('books');

        /**
         * Filtrar por nombre.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $bookSagas = $bookSagas->where('name', 'like', '%' . $search . '%');
        }

        /**
         * Filtrar por generos.
         */
        if (isset($query['genres'])) {
            $genres = explode(',', str_replace('-', ' ', $query['genres']));
            $bookSagas = $bookSagas->whereHas('books', function ($q) use ($genres) {
                $q->whereHas('genres', function ($query) use ($genres) {
                    $query->whereIn('name', $genres);
                });
            });
        }

        /**
         * Filtrar por autor.
         */
        if (isset($query['author'])) {
            $search = str_replace('-', ' ', $query['author']);
            $bookSagas = $bookSagas->whereHas('books', function ($q) use ($search) {
                $q->whereHas('authors', function ($query) use ($search) {
                    $query->whereRaw('concat(name, " ", lastname) like ?', '%' . $search . '%');
                });
            });
        }

        /**
         * Ordenar por valoración de las reseñas en burningmeter y readerScore.
         */
        // Pendiente

        $bookSagas = $bookSagas->get();
        foreach ($bookSagas as $bookSaga) {
            $bookSaga["genres"] = $bookSaga->getGenresAttribute();
            $bookSaga["authors"] = $bookSaga->getAuthorsAttribute();
        }

        return response()->json(['bookSagas' => BookSagaResource::collection($bookSagas)], 200);
    }

    /**
     * Obtener todas las sagas de un autor.
     */
    public function indexByAuthor(Request $request, string  $author)
    {
        $bookSagas = BookSaga::select('bookSagas.*')
            ->join('bookCollections', 'bookCollections.bookSaga_id', '=', 'bookSagas.id')
            ->join('bookWriters', 'bookWriters.book_id', '=', 'bookCollections.book_id')
            ->where('bookWriters.author_id', '=', $author)
            ->distinct()
            - with('books')
            ->get();
        return response()->json(['bookSagas' => BookSagaResource::collection($bookSagas)], 200);
    }

    /**
     * Obtener todas las sagas de un libro.
     */
    public function indexByBook(Request $request, string  $book)
    {
        $bookSagas = Book::find($book)->bookSagas()->get();
        $bookSagas->load('books');
        return response()->json(['bookSagas' => BookSagaResource::collection($bookSagas)], 200);
    }

    /**
     * Crear una nueva saga.
     */
    public function store(BookSagaStoreRequest $request)
    {
        $request['burningmeter'] = 0;
        $request['readersScore'] = 0;
        $bookSaga = BookSaga::create($request->all());
        if (isset($request->books)) {
            $bookSaga->books()->attach($request->books, ['order' => 1]);
            $bookSaga->load('books');
            $bookSaga["genres"] = $bookSaga->getGenresAttribute();
            $bookSaga["authors"] = $bookSaga->getAuthorsAttribute();
        }
        return response()->json(['bookSaga' => $bookSaga], 201);
    }

    /**
     * Añadir un libro a una saga
     */
    public function addBook(AddBookStoreRequest $request, string $bookSaga, string $book)
    {
        $bookSaga = BookSaga::find($bookSaga);
        $bookSaga->books()->attach($book, ['order' => $request->order]);
        $bookSaga->load('books');
        return response()->json(['bookSaga' => new BookSagaResource($bookSaga)], 201);
    }

    public function addReview(Request $request, string $bookSaga, string $sagaReview)
    {
        $bookSaga = BookSaga::find($bookSaga);
        $bookSaga->reviews()->attach($sagaReview);
        return response()->json(['bookSaga' => $bookSaga], 201);
    }

    /**
     * Obtener una saga.
     */
    public function show(BookSaga $bookSaga)
    {
        $bookSaga->load('books');
        $bookSaga["genres"] = $bookSaga->getGenresAttribute();
        $bookSaga["authors"] = $bookSaga->getAuthorsAttribute();

        return response()->json(['bookSaga' => new BookSagaResource($bookSaga)], 200);
    }

    /**
     * Actualizar una saga.
     */
    public function update(BookSagaUpdateRequest $request, BookSaga $bookSaga)
    {
        $bookSaga->update($request->all());
        return response()->json(['bookSaga' => new BookSagaResource($bookSaga)], 200);
    }

    /**
     * Eliminar una saga.
     */
    public function destroy(BookSaga $bookSaga)
    {
        $bookSaga->books()->detach();
        $bookSaga->delete();
        return response()->json(['message' => 'Book Saga successfully removed'], 200);
    }

    /**
     * Remover un libro a una saga
     */
    public function removeBook(Request $request, string $bookSaga, string $book)
    {
        $bookSaga = BookSaga::find($bookSaga);
        $bookSaga->books()->detach($book);
        $bookSaga->load('books');
        return response()->json(['bookSaga' => new BookSagaResource($bookSaga)], 201);
    }
}
