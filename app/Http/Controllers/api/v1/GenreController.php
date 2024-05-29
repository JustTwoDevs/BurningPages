<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Http\Requests\api\v1\GenreStoreRequest;
use App\Http\Requests\api\v1\GenreUpdateRequest;
use App\Http\Resources\GenreResource;
use Illuminate\Database\QueryException;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json(['genres' => GenreResource::collection($genres)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreStoreRequest $request)
    {
        $genre = Genre::create($request->all());
        return response()->json(['genre' => $genre], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return response()->json(['genre' => new GenreResource($genre)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreUpdateRequest $request, Genre $genre)
    {
        $genre->update($request->all());
        return response()->json(['genre' =>  new GenreResource($genre)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        try {
            $genre->delete();
            return response()->json(['message' => 'Genre successfully removed'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'The are resources that already use this genre plz remove them before'], 400);
        }
    }
}
