<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

//    /**
//     * Test de la récupération de la liste des catégories.
//     * Function : Index()
//     *
//     * @return void
//     */
//    public function testGetAllCategories()
//    {
//        // Create some categories with associated movies in the database
//        $categories = Category::factory()->hasMovies(3)->count(3)->create();
//
//        $jsonResponse = $this->get('/api/categories/json');
//        $jsonResponse->assertStatus(Response::HTTP_OK);
//
//        // Check the JSON structure
//        $jsonResponse->assertJsonStructure([
//            '*' => [
//                'category_name',
//                'movies' => [
//                    '*' => [
//                        'name',
//                        'description',
//                        'release_date',
//                        'note',
//                        'uri',
//                    ],
//                ],
//            ],
//        ]);
//
//        // Check the content of the JSON response
//        $jsonResponse->assertJson(function (AssertableJson $json) use ($categories) {
//            $json
//                ->where('category_name', $categories[0]->name)
//                ->where('movies', function ($moviesJson) use ($categories) {
//                    $moviesJson
//                        ->where('name', $categories[0]->movies[0]->name)
//                        ->where('description', $categories[0]->movies[0]->description)
//                        ->where('release_date', $categories[0]->movies[0]->release_date)
//                        ->where('note', $categories[0]->movies[0]->note)
//                        ->where('image_url', $categories[0]->movies[0]->image_url);
//                });
//        });
//
//        // Send a request to retrieve categories in XML format
//        $xmlResponse = $this->get('/api/categories/xml');
//
//        // Check that the XML response is successful
//        $xmlResponse->assertStatus(Response::HTTP_OK);
//
//        // Check the XML structure
//        // Add assertions for XML structure if necessary
//    }

    /**
     * Test storing a new category.
     * Function : Store()
     *
     * @return void
     */
    public function testCreateCategory()
    {
        // Données de la nouvelle catégorie à stocker
        $requestData = [
            'name' => 'Nouvelle catégorie',
        ];

        $jsonResponse = $this->post('/api/category/json', $requestData);
        $jsonResponse->assertStatus(Response::HTTP_CREATED);

        // Vérifier que la catégorie a été correctement ajoutée à la base de données
        $this->assertDatabaseHas('categories', ['name' => $requestData['name']]);
    }

    /**
     * Supprimer la catégorie créée à la fin du test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Category::where('name', 'Nouvelle catégorie')->delete();
        parent::tearDown();
    }

    /**
     * Test retrieving a specific category.
     * Function : Show()
     *
     * @return void
     */
    public function testGetCategoryById()
    {
        // Créer une catégorie dans la base de données
        $category = Category::factory()->create();

        $jsonResponse = $this->get("/api/category/{$category->id}/json");
        $jsonResponse->assertStatus(Response::HTTP_OK);

        // Vérifier la structure de la réponse JSON
        $jsonResponse->assertJsonStructure([
            'id',
            'name',
            'movies' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'release_date',
                    'note',
                    'image_url',
                ],
            ],
        ]);

        // Vérifier le contenu de la réponse JSON
        $jsonResponse->assertJson([
            'id' => $category->id,
            'name' => $category->name,
        ]);

        $category->delete();
    }

//    /**
//     * Test updating a category.
//     * Function : Update()
//     *
//     * @return void
//     */
//    public function testUpdate()
//    {
//        // Créer une catégorie dans la base de données
//        $category = Category::factory()->create();
//
//        // Données de mise à jour de la catégorie
//        $updatedData = [
//            'name' => 'Nom de catégorie mis à jour'. uniqid(),
//        ];
//
//        $response = $this->patch("/api/category/{$category->id}/json", $updatedData);
//        $response->assertStatus(Response::HTTP_CREATED);
//
//        // Actualiser l'objet de la catégorie depuis la base de données
//        $category->refresh();
//
//        // Vérifier que les données de la catégorie ont été mises à jour correctement
//        $this->assertEquals($updatedData['name'], $category->name);
//    }

    /**
     * Test destroying a category.
     * Function : Destroy()
     *
     * @return void
     */
    public function testDeleteCategory()
    {
        // Créer une catégorie dans la base de données
        $category = Category::factory()->create();

        $response = $this->delete("/api/category/{$category->id}");
        $response->assertStatus(Response::HTTP_OK);

        // Vérifier que la catégorie a été supprimée de la base de données
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
