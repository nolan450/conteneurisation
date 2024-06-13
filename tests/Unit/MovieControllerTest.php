<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Configurer la base de données et exécuter les migrations
        $this->artisan('migrate')->run();
    }

    /**
     * Test de la récupération de la liste des films.
     * Function : Index()
     *
     * @return void
     */
    public function testGetListOfMovies()
    {
        // Crée quelques films factices dans la base de données pour les tester
        $movie = Movie::factory()->create();

        // Exécute la requête HTTP pour récupérer la liste des films
        $response = $this->get("/api/movies");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([]);

        $movie->delete();

    }

    // TODO test getImage
    //    public function testGetImage()
    //    {
    //        // Créer un fichier image fictif pour le test
    //        $filename = 'test-image.png';
    //        $imagePath = 'public/movies/' . $filename;
    //        file_put_contents($imagePath, '');
    //
    //        // Simuler le stockage pour que le contrôleur utilise le stockage factice pendant le test
    //        Storage::fake('public');
    //        Storage::disk('public')->put('movies/' . $filename, '');
    //
    //        $response = $this->get("/api/movies/{$filename}");
    //        $response->assertStatus(Response::HTTP_OK);
    //
    //        // Vérifier que le type de contenu de la réponse est une image
    //        $response->assertHeader('Content-Type', 'image/jpeg');
    //
    //        // Supprimer le fichier image fictif après le test
    //        unlink($imagePath);
    //    }

//    /**
//     * Test de la récupération d'un film par son ID.
//     * Function : Show()
//     *
//     * @return void
//     */
//    public function testGetMovieById()
//    {
//        $movie    = Movie::factory()->create();
//        $response = $this->get("/api/movies/{$movie->uid}");
//        $response->assertStatus(Response::HTTP_OK);
//
//        $response->assertJson([
//            'uid'          => $movie->uid,
//            'name'         => $movie->name,
//            'description'  => $movie->description,
//            'rate' => $movie->rate,
//            'duration' => $movie->duration,
//        ]);
//
//        $movie->delete();
//    }

//    /**
//     * Test de la création d'un film.
//     * Function : Store()
//     *
//     * @return void
//     */
//    public function testCreateMovie()
//    {
//        // Crée une instance de Request avec les données du film à créer
//        $requestData = [
//            'name'         => 'Nom du film2',
//            'description'  => 'Description du film',
//            'release_date' => '2024-02-07',
//            'note'         => 4
//        ];
//
//        $request = new Request($requestData);
//
//        // Exécute la méthode de création du film dans le contrôleur
//        $controller = new \App\Http\Controllers\MovieController();
//        $response   = $controller->store($request, 'json');
//        $this->assertEquals(201, $response->getStatusCode());
//
//        // Vérifie que le film a été correctement créé en vérifiant les données dans la base de données
//        $movie = Movie::where('name', $requestData['name'])->first();
//        $this->assertNotNull($movie);
//        $this->assertEquals($requestData['description'], $movie->description);
//        $this->assertEquals($requestData['release_date'], $movie->release_date);
//        $this->assertEquals($requestData['note'], $movie->note);
//
//        $movie->delete();
//    }

//    /**
//     * Test de la mise à jour d'un film.
//     *
//     * @return void
//     */
//    public function testUpdateMovie()
//    {
//        $movie = Movie::factory()->create();
//
//        // Données de mise à jour du film
//        $updatedData = [
//            'name'         => 'Film mis à jour'  . uniqid(),
//            'description'  => 'Nouvelle description du film',
//            'release_date' => '2023-01-01',
//            'note'         => 5,
//        ];
//        $response = $this->patch("/api/movies/{$movie->id}", $updatedData);
//        $response->assertStatus(Response::HTTP_CREATED);
//
//        $movie->refresh();
//
//        // Vérifie que les données du film ont été mises à jour correctement
//        $this->assertEquals($updatedData['name'], $movie->name);
//        $this->assertEquals($updatedData['description'], $movie->description);
//        $this->assertEquals($updatedData['rate'], $movie->rate);
//        $this->assertEquals($updatedData['duration'], $movie->duration);
//    }

    /**
     * Test de la suppression d'un film.
     * Function : Destroy()
     *
     * @return void
     */
    public function testDeleteMovie()
    {
        $movie    = Movie::factory()->create();
        $response = $this->delete("/api/movies/{$movie->uid}");
        $response->assertStatus(Response::HTTP_OK);

        // Vérifie que le film a été correctement supprimé de la base de données
        $this->assertDatabaseMissing('movies', ['uid' => $movie->uid]);
    }
}
