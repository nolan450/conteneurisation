<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Spatie\ArrayToXml\ArrayToXml;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $output_format
     * @return mixed
     */
    public function index(string $output_format): mixed
    {
        $categories = Category::with("movies")->orderBy("id")->get();

        switch ($output_format) {
            case 'json':
                $test = $categories->map(function ($category) {
                    $testa = $category->movies->map(function ($movie) {
                        return [
                            "uuid"         => $movie->uuid,
                            "name"         => $movie->name,
                            "description"  => $movie->description,
                            "release_date" => $movie->release_date,
                            "note"         => $movie->note,
                            "uri"          => URL::to("api/movie/{$movie->id}/json")
                        ];
                    });

                    return [
                        'category_name' => $category->name,
                        'movies'        => $testa->toArray(),
                    ];
                });

                return response()->json($test, 200);

            case 'xml':
                $xml = new \SimpleXMLElement('<categories/>');
                foreach ($categories as $category) {
                    $categoryXml = $xml->addChild('category');
                    $categoryXml->addChild('name', $category->name);

                    foreach ($category->movies as $movie) {
                        $movieXml = $categoryXml->addChild('movie');
                        $movieXml->addChild('uuid', $movie->uuid);
                        $movieXml->addChild('name', $movie->name);
                        $movieXml->addChild('description', $movie->description, 'UTF-8');
                        $movieXml->addChild('release_date', $movie->release_date);
                        $movieXml->addChild('note', $movie->note);
                        $movieXml->addChild('uri', URL::to("api/movie/{$movie->id}/xml"));
                    }
                }

                $response = new HttpResponse($xml->asXML(), 200);
                $response->header('Content-Type', 'application/xml; charset=utf-8');

                return $response;

            default:
                return response("Ce format n'est pas pris en charge", 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $request
     * @param $output_format
     * @return mixed
     */
    public function store(Request $request, string $output_format): mixed
    {
        $validated = Validator::make(
            $request->all(),
            [
                "name" => "required|max:128",
            ]
        );

        if ($validated->fails()) {
            return new JsonResponse(['errors' => $validated->errors()], 422);
        }

        $category = Category::create($request->all());

        switch ($output_format) {
            case 'json':
                return new JsonResponse($category, 201);


            case 'xml':
                $result = new ArrayToXml($category->toArray(), [], true, 'UTF-8');
                return response($result->toXml(), 201);


            default:
                return response("Ce format n'est pas pris en charge", 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @param string $output_format
     *
     * @return mixed
     */
    public function show(Category $category, string $output_format): mixed
    {
        if (!Category::find($category)) {
            return response("Cette catégorie n'a pas été trouvée", 404);
        }


        switch ($output_format) {
            case 'json':
                return new JsonResponse($category->load("movies"), 200);


            case 'xml':
                $result = new ArrayToXml($category->load("movies")->toArray(), [], true, 'UTF-8');
                return response($result->toXml(), 200);


            default:
                return response("Ce format n'est pas pris en charge", 400);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @param string $output_format
     * @return mixed
     */
    public function update(Request $request, Category $category, string $output_format)
    {
        if (!Category::find($category)) {
            return response("Cette catégorie n'a pas été trouvée", 404);
        }

        $validated = Validator::make(
            $request->all(),
            [
                "name" => "required|max:128",
            ]
        );

        if ($validated->fails()) {
            return new JsonResponse(['errors' => $validated->errors()], 422);
        }

        $category = Category::create($request->all());

        switch ($output_format) {
            case 'json':
                return new JsonResponse($category, 201);


            case 'xml':
                $result = new ArrayToXml($category->toArray(), [], true, 'UTF-8');
                return response($result->toXml(), 201);


            default:
                return response("Ce format n'est pas pris en charge", 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     *
     * @return ResponseFactory
     */
    public function destroy(Category $category)
    {
        if (!Category::find($category)) {
            return response("Cette catégorie n'a pas été trouvée", 404);
        }

        $category->delete();

        return response('Catégorie supprimée', 200);
    }
}
