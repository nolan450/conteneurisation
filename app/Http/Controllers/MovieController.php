<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed Collection of movies
     */
    public function index(): mixed
    {
        $movies = Movie::when(Request()->input('query'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->OrWhere('description', 'like', '%' . $search . '%');
        })->get();

        if ($movies->isEmpty()) {
            return response()->json(['error' => 'Aucun résultat'], 404);
        }

        return response()->json($movies, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param string $uid
     * @return mixed
     */
    public function show(string $uid): mixed
    {
        $movie = Movie::where('uid', $uid)->get();

        if ($movie->isEmpty()) {
            return response("Ce film n'a pas été trouvé", 404);
        }

        return json_encode($movie->load("categories"), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'        => 'required | max:128',
                'description' => 'required | max:2048',
                'rate'        => 'required | integer | min:1 | max:5',
                'duration'    => 'required | integer | min:0 | not_in:0 | max:240 | not_in:240',
            ]
        );

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $movie              = new Movie();
        $movie->uid         = Uuid::uuid4();
        $movie->name        = $validatedData['name'];
        $movie->description = $validatedData['description'];
        $movie->duration    = $validatedData['duration'];
        $movie->rate        = $validatedData['rate'];
        $movie->save();

        return new JsonResponse($movie, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Movie $movie
     *
     * @return mixed
     * @throws ValidationException
     */
    public function update(Request $request, Movie $movie): mixed
    {
        if (!Movie::find($movie)) {
            return response("Ce film n'a pas été trouvé", 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name'        => 'required | max:128',
                'description' => 'required | max:2048',
                'rate'        => 'required | integer | min:1 | max:5',
                'duration'    => 'required | integer | min:0 | not_in:0 | max:240 | not_in:240',
            ]
        );

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $movie->name        = $validatedData['name'];
        $movie->description = $validatedData['description'];
        $movie->duration    = $validatedData['duration'];
        $movie->rate        = $validatedData['rate'];
        $movie->save();

        return new JsonResponse($movie, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     *
     * @return ResponseFactory
     */
    public function destroy(Movie $movie): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
    {
        if (!Movie::find($movie)) {
            return response("Ce film n'a pas été trouvé", 404);
        }

        $movie->delete();

        return response('Film supprimé', 200);
    }
}
