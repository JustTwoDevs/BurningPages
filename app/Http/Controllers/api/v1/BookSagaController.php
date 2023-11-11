<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookSaga;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookSagaController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        $bookSagas = BookSaga::with('books')->get();

        foreach ($bookSagas as $bookSaga) {
            $bookSaga["genres"] = $bookSaga->getGenresAttribute();
            $bookSaga["authors"] = $bookSaga->getAuthorsAttribute();
        }
        return response()->json(['bookSagas' => $bookSagas], 200);
    }

    /**
     * Display a listing of the resource by author.
     */
    public function indexByAuthor(Request $request, string  $author)
    {
        //BookSaga no tiene relación directa con Author, por lo que hay que hacer una consulta más compleja
        $bookSagas = BookSaga::select('bookSagas.*')
            ->join('bookWriters', 'bookWriters.bookSaga_id', '=', 'bookSagas.id')
            ->join('authors', 'authors.id', '=', 'bookWriters.author_id')
            ->where('authors.id', '=', $author)
            ->distinct()
            ->get();
        return response()->json(['bookSagas' => $bookSagas], 200);
    }

    /**
     * Display a listing of the resource by book.
     */
    public function indexByBook(Request $request, string  $book)
    {
        $bookSagas = Book::find($book)->bookSagas()->get();
        return response()->json(['bookSagas' => $bookSagas], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bookSaga = BookSaga::create($request->all());
        $bookSaga->authors()->attach($request->authors);
        $bookSaga->books()->attach($request->books);
        $bookSaga->genres()->attach($request->genres);
        return response()->json(['bookSaga' => $bookSaga], 201);
    }

    /**
     * Añadir un libro a una saga
     */
    public function addBook(Request $request, string $bookSaga, string $book)
    {
        $bookSaga = BookSaga::find($bookSaga);
        $bookSaga->books()->attach($book);
        return response()->json(['bookSaga' => $bookSaga], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookSaga $bookSaga)
    {
        info('BookSaga data:');
        $bookSaga->load('books');
        $bookSaga["genres"] = $bookSaga->getGenresAttribute();
        $bookSaga["authors"] = $bookSaga->getAuthorsAttribute();

        return response()->json(['bookSaga' => $bookSaga], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookSaga $bookSaga)
    {
        $bookSaga->update($request->all());
        $bookSaga->authors()->sync($request->authors);
        $bookSaga->books()->sync($request->books);
        return response()->json(['bookSaga' => $bookSaga], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookSaga $bookSaga)
    {
        $bookSaga->books()->detach();
        $bookSaga->authors()->detach();
        $bookSaga->genres()->detach();
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
        return response()->json(['bookSaga' => $bookSaga], 201);
    }
}
