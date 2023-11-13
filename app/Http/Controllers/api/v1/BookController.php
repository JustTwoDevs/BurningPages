<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookSaga;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * Es posible filtrar por género, rango de fecha de publicación, idioma original, titulo y autor (Nombre, apellido, pseudónimo).
     * Es posible ordenar por valoración de las reseñas en burningmeter y readerScore, y por fecha de publicación.
     * 
     * Ejemplos:
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
        $books = Book::with('authors', 'genres', 'bookSagas', 'reviews');

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
         * Filtrar por género
         * whereIn - Agrega el operador in a la consulta
         *     whereIn('columna', [valor1, valor2])
         */
        if (isset($query['genres'])) {
            $genres = explode(',', $query['genres']);
            $books = $books->whereHas('genres', function ($q) use ($genres) {
                $q->whereIn('genres.name', $genres);
            });
        }

        /**
         * Filtrar por rango de fecha de publicación
         * whereBetween - Agrega el operador between a la consulta
         *      whereBetween('columna', [valor1, valor2])
         */
        if (isset($query['range'])) {
            $range = explode(',', $query['range']);
            $books = $books->whereBetween('publication_date', $range);
        }

        /**
         * Filtrar por idioma original
         */
        if (isset($query['originalLanguage'])) {
            $books = $books->where('original_language', $query['originalLanguage']);
        }

        /**
         * Filtrar por titulo
         */
        if (isset($query['title'])) {
            $books = $books->where('title', 'like', '%' . $query['title'] . '%');
        }

        /**
         * Filtrar por autor
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
    }

    /**
     * Display a listing of the resource by author.
     */
    public function indexByAuthor(Request $request, string $author)
    {
        $books = Author::find($author)->books()->get();
        return response()->json(['books' => $books], 200);
    }

    /**
     * Display a listing of the resource by book saga.
     */
    public function indexByBookSaga(Request $request, string $booksaga)
    {
        $books = BookSaga::find($booksaga)->books()->get();
        return response()->json(['books' => $books], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        $book->authors()->attach($request->authors);
        $book->genres()->attach($request->genres);
        return response()->json(['book' => $book], 201);
    }

    /**
     * Añadir un genero a un libro
     */
    public function addGenre(Request $request, string $book, string $genre)
    {
        $book = Book::find($book);
        $book->genres()->attach($genre);
        return response()->json(['book' => $book], 201);
    }

    /**
     * Añadir un autor a un libro
     */
    public function addAuthor(Request $request, string $book, string $author)
    {
        $book = Book::find($book);
        $book->authors()->attach($author);
        return response()->json(['book' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['authors', 'genres', 'bookSagas']);
        return response()->json(['book' => $book], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $book->update($request->all());
        $book->authors()->sync($request->authors);
        return response()->json(['book' => $book], 200);
    }

    /**
     * Remove the specified resource from storage.
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
        return response()->json(['book' => $book], 201);
    }
}
