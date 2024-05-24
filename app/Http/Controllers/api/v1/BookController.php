<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookSaga;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\BookStoreRequest;
use App\Http\Requests\api\v1\BookUpdateRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * Es posible filtrar por género, rango de fecha de publicación, idioma original, titulo y autor (Nombre, apellido, pseudónimo).
     * Es posible ordenar por valoración de las reseñas en burningmeter y readerScore, y por fecha de publicación.
     *
     * Ejemplos:
     * /books?search=Harry-Potter
     * /books?genres=novel,romance
     * /books?range=2010-01-01,2020-01-01
     * /books?originalLanguage=es
     * /books?title=Harry-Potter
     * /books?author=J.K-Rowling -> La busqueda se hace por nombre completo y pseudónimo
     * /books?sortBy=publicationDate&sortOrder=asc -> Si no se especifica el orden, se ordena de forma descendente
     */
    public function index(Request $request)
    {
        $query = $request->query();
        $books = Book::query()->with('authors', 'genres', 'bookSagas');

        /**
         *  A tener en cuenta:
         *  isset - Determina si una variable está definida y no es null
         *  explode - Divide un string en un array de strings dado un delimitador
         *  whereHas - Agrega restricciones "where" a la consulta
         *     whereHas('relacion', function($q) use ($variable) {
         *        $q->where('columna', $variable);
         *     });
         */


        /**
         * Filtrar por busqueda.
         * Busca en el titulo, nombre de los autores y pseudónimos.
         */
        if (isset($query['search'])) {
            $search = str_replace('-', ' ', $query['search']);
            $books = $books->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('authors', function ($q) use ($search) {
                    $q->whereRaw('concat(name, " ", lastname) like ?', '%' . $search . '%')
                        ->orWhere('pseudonym', 'like', '%' . $search . '%');
                });
        }

        /**
         * Filtrar por género.
         * whereIn - Agrega el operador in a la consulta
         *     whereIn('columna', [valor1, valor2])
         */
        if (isset($query['genres'])) {
            $genres = explode(',', str_replace('-', ' ', $query['genres']));
            $books = $books->whereHas('genres', function ($q) use ($genres) {
                $q->whereIn('genres.name', $genres);
            });
        }

        /**
         * Filtrar por rango de fecha de publicación.
         * whereBetween - Agrega el operador between a la consulta
         *      whereBetween('columna', [valor1, valor2])
         */
        if (isset($query['range'])) {
            $range = explode(',', $query['range']);
            $books = $books->whereBetween('publication_date', $range);
        }

        /**
         * Filtrar por idioma original.
         */
        if (isset($query['originalLanguage'])) {
            $books = $books->where('original_language', $query['originalLanguage']);
        }

        /**
         * Filtrar por titulo.
         */
        if (isset($query['title'])) {
            $search = str_replace('-', ' ', $query['title']);
            $books = $books->where('title', 'like', '%' . $search . '%');
        }

        /**
         * Filtrar por autor.
         * whereRaw - Agregar una clausula where sin formato, permitiendo expresiones SQL
         * Acepta un segundo parámetro con los valores a reemplazar en la consulta. El simbolo ? representa el valor a reemplazar
         */
        if (isset($query['author'])) {
            $search = str_replace('-', ' ', $query['author']);
            $books = $books->whereHas('authors', function ($q) use ($search) {
                $q->whereRaw('concat(name, " ", lastname) like ?', '%' . $search . '%')
                    ->orWhere('pseudonym', 'like', '%' . $search . '%');
            });
        }

        /**
         * Ordenamientos.
         * orderBy - Agrega una clausula order by a la consulta
         *    orderBy('columna', 'asc|desc')
         */
        if (isset($query['sortBy'])) {

            // Ordenamiento por fecha de publicación
            if ($query['sortBy'] == 'publicationDate') {
                $books = $books->orderBy('publication_date', $query['sortOrder'] ?? 'desc');
            }

            // Ordenamiento por valoración de las reseñas en burningmeter y readerScore

        }

        $books = $books->get();

        // Cargar las imagenes si es que tienen la ruta
        $books->each(function ($book) {
            if ($book->image_path) {
                $book->image_path = url('storage/' . $book->image_path);
            }
        });

        return response()->json(['books' =>  BookResource::collection($books)], 200);
    }

    /**
     * Obtener todos los libros de un autor.
     */
    public function indexByAuthor(Request $request, string $author)
    {
        $books = Author::find($author)->books()->get();
        $books->load(['genres']);
        return response()->json(['books' =>  BookResource::collection($books)], 200);
    }

    /**
     * Obtener todos los libros de una saga.
     */
    public function indexByBookSaga(Request $request, string $bookSaga)
    {
        $books = BookSaga::find($bookSaga)->books()->get();
        $books->load(['genres']);
        return response()->json(['books' => BookResource::collection($books)], 200);
    }

    /**
     * Crear un nuevo libro.
     */
    public function store(BookStoreRequest $request)
    {
        $request['burningmeter'] = 0;
        $request['readersScore'] = 0;

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('public');
            $path = str_replace('public/', '', $path);
            $request['image_path'] = $path;
        }

        $book = Book::create($request->all());
        if ($request->authors) $book->authors()->attach($request->authors);
        if ($request->genres) $book->genres()->attach($request->genres);

        return response()->json(['book' => $book], 201);
    }

    /**
     * Añadir un genero a un libro
     */
    public function addGenre(Request $request, string $book, string $genre)
    {
        $book = Book::find($book);
        $book->genres()->attach($genre);
        $book->load('genres');
        return response()->json(['book' => new BookResource($book)], 201);
    }


    public function addReview(Request $request, string $book, string $review)
    {
        $book = Book::find($book);
        $book->reviews()->attach($review);
        return response()->json(['book' => $book], 201);
    }

    /**
     * Obtener un libro.
     */
    public function show(Book $book)
    {
        $book->load(['authors', 'genres', 'bookSagas']);
        return response()->json(['book' => new BookResource($book)], 200);
    }

    /**
     * Actualizar un libro.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('public');
            $path = str_replace('public/', '', $path);
            $book->image_path = $path;
            $book->save();
        }

        $book->update($request->all());
        return response()->json(['book' => new BookResource($book)], 200);
    }

    /**
     * Remover un libro.
     */
    public function destroy(Book $book)
    {
        $book->genres()->detach();
        $book->authors()->detach();
        $book->bookSagas()->detach();
        $book->delete();
        return response()->json(['message' => 'Book successfully removed'], 200);
    }

    /**
     * Remover un genero a un libro
     */
    public function removeGenre(Request $request, string $book, string $genre)
    {
        $book = Book::find($book);
        $book->genres()->detach($genre);
        $book->load('genres');
        return response()->json(['book' => new BookResource($book)], 201);
    }
}
