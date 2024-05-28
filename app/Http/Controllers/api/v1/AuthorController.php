<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\AuthorStoreRequest;
use App\Http\Requests\api\v1\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Obtener todos los autores.
     * Es posible filtrar por nombre completo, pseudónimo, nacionalidad y género.
     * Es posible ordenar por nombre completo.
     *
     * Ejemplos:
     * /authors?search=J.K-Rowling
     * /authors?name=J.K-Rowling
     * /authors?pseudonym=Gabo
     * /authors?nationality=Colombia
     * /authors?genres=novel,romance
     * /authors?sortBy=name&sortOrder=asc -> Si no se especifica el orden, se ordena de forma descendente
     */
    public function index(Request $request)
    {
        $query = $request->query();
        $authors = Author::query()->with(['books', 'nationality']);

        /**
         * Filtrar por busqueda.
         * Busca en el nombre completo y pseudónimo.
         */
        if (isset($query['search'])) {
            $search = str_replace('-', ' ', $query['search']);
            $authors = $authors->whereRaw('concat(name, " ", lastname) like ?', '%' . $search . '%')
                ->orWhere('pseudonym', 'like', '%' . $search . '%');
        }

        /**
         * Filtrar por nombre completo.
         */
        if (isset($query['name'])) {
            $search = str_replace('-', ' ', $query['name']);
            $authors = $authors->whereRaw('concat(name, " ", lastname) like ?', '%' . $search . '%');
        }

        /**
         * Filtrar por pseudónimo.
         */
        if (isset($query['pseudonym'])) {
            $search = str_replace('-', ' ', $query['pseudonym']);
            $authors = $authors->where('pseudonym', 'like', '%' . $search . '%');
        }

        /**
         * Filtrar por nacionalidad.
         */
        if (isset($query['nationality'])) {
            $search = str_replace('-', ' ', $query['nationality']);
            $nationality = Nationality::where('name', $search)->first();
            $authors = $authors->where('nationality_id', $nationality->id);
        }

        /**
         * Filtrar por género.
         */
        if (isset($query['genres'])) {
            $genres = explode(',', str_replace('-', ' ', $query['genres']));
            $authors = $authors->whereHas('books', function ($q) use ($genres) {
                $q->whereHas('genres', function ($query) use ($genres) {
                    $query->whereIn('name', $genres);
                });
            });
        }

        /**
         * Ordenamiento por nombre.
         */
        if (isset($query['sortBy'])) {
            $authors = $authors->sortBy('name', $query['sortOrder'] ?? 'desc');
        }

        $authors = $authors->get();

        foreach ($authors as $author) {
            $author["genres"] = $author->getGenresAttribute();
            $author["bookSagas"] = $author->getBookSagasAttribute();
            if ($author->image_path) {
                $author->image_path = url('storage/' . $author->image_path);
            }
        }

        return response()->json(['authors' => AuthorResource::collection($authors)], 200);
    }

    /**
     * Obtener todos los autores asociados a un libro.
     */
    public function indexByBook(Request $request, string $book)
    {
        $authors = Book::find($book)->authors()->get();
        $authors->load('nationality');
        return response()->json(['authors' => AuthorResource::collection($authors)], 200);
    }

    /**
     * Obtener todos los autores asociados a una saga.
     */
    public function indexByBookSaga(Request $request, string $bookSaga)
    {
        $authors = Author::select('authors.*')
            ->join('bookWriters', 'bookWriters.author_id', '=', 'authors.id')
            ->join('bookCollections', 'bookCollections.book_id', '=', 'bookWriters.book_id')
            ->where('bookCollections.bookSaga_id', '=', $bookSaga)
            ->distinct()
            ->with('nationality')
            ->get();

        return response()->json(['authors' => AuthorResource::collection($authors)], 200);
    }

    /**
     * Crear un nuevo autor.
     */
    public function store(AuthorStoreRequest $request)
    {
        $request['image_path'] = $request->input('cover');
        $author = Author::create($request->all());
        $author->load('nationality');
        return response()->json(['author' => $author], 201);
    }

    /**
     * Añadir un libro a un autor.
     */
    public function addBook(Request $request, string $author, string $book)
    {
        $author = Author::find($author);
        $author->books()->attach($book);
        $author->load('books');
        return response()->json(['author' => new AuthorResource($author)], 201);
    }

    /**
     * Obtener un autor
     */
    public function show(Author $author)
    {
        $author->load('books');
        $author["genres"] = $author->getGenresAttribute();
        $author["bookSagas"] = $author->getBookSagasAttribute();
        if ($author->image_path) {
            $author->image_path = url('storage/' . $author->image_path);
        }
        return response()->json(['author' => new AuthorResource($author)], 200);
    }

    /**
     * Actualizar un autor.
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $request['image_path'] = $request->input('cover');
        $author->update($request->all());
        $author->load('nationality');
        return response()->json(['author' => new AuthorResource($author)], 200);
    }

    /**
     * Eliminar un autor.
     */
    public function destroy(Author $author)
    {
        Storage::delete('public/' . $author->image_path);
        $author->delete();
        return response()->json(['message' => 'Author successfully removed'], 200);
    }

    /**
     * Remover un libro a un autor.
     */
    public function removeBook(Request $request, string $author, string $book)
    {
        $author = Author::find($author);
        $author->books()->detach($book);
        $author->load('books');
        return response()->json(['author' => new AuthorResource($author)], 201);
    }
}
