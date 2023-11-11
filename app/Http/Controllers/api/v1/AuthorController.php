<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::with('books')->get();
        foreach ($authors as $author) {
            $author["genres"] = $author->getGenresAttribute();
            $author["bookSagas"] = $author->getBookSagasAttribute();
        }
        return response()->json(['authors' => $authors], 200);
    }

    /**
     * Display a listing of the resource by the book.
     */
    public function indexByBook(Request $request, string $book)
    {
        $authors = Book::find($book)->authors()->get();
        return response()->json(['authors' => $authors], 200);
    }

    /**
     * Display a listing of the resource by the book saga.
     */
    public function indexByBookSaga(Request $request, string $booksaga)
    {
        //Autor no tiene relación directa con BookSaga, por lo que hay que hacer una consulta más compleja
        $authors = Author::select('authors.*')
            ->join('bookWriters', 'bookWriters.author_id', '=', 'authors.id')
            ->join('bookCollections', 'bookCollections.book_id', '=', 'bookWriters.book_id')
            ->where('bookCollections.bookSaga_id', '=', $booksaga)
            ->distinct()
            ->get();
        return response()->json(['authors' => $authors], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $author = Author::create($request->all());
        return response()->json(['author' => $author], 201);
    }

    /**
     * Añadir un libro a un autor
     */
    public function addBook(Request $request, string $author, string $book)
    {
        $author = Author::find($author);
        $author->books()->attach($book);
        return response()->json(['author' => $author], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load('books');
        $author["genres"] = $author->getGenresAttribute();
        $author["bookSagas"] = $author->getBookSagasAttribute();
        return response()->json(['author' => $author], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $author->update($request->all());
        return response()->json(['author' => $author], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json(['message' => 'Author successfully removed'], 200);
    }

    /**
     * Remover un libro a un autor
     */
    public function removeBook(Request $request, string $author, string $book)
    {
        $author = Author::find($author);
        $author->books()->detach($book);
        return response()->json(['author' => $author], 201);
    }
}
