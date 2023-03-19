<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class ProductControllerTest extends TestCase
{
    /** @test */
    public function it_shows__list_of_products()
    {
        $product = Product::factory(10)->create();

        $response = $this->getJson(action([ProductController::class, 'index']));
        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'body',
                        'user'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_creates_product()
    {
        Storage::fake();
        $product = Product::factory()->raw([
            'path' => UploadedFile::fake()->image('product2.jpg')
        ]);

        $response = $this->postJson(action([ProductController::class, 'store']), $product);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'body',
                    'user'
                ]
            ])
            ->assertJsonFragment(['title' => $product['title']])
            ->assertJsonFragment(['body' => $product['body']]);

        Storage::assertExists($response->json('data.path'));
    }

    /** @test */
    public function it_updates_product()
    {
        Storage::fake();
        $product = Product::factory()->create();

        $response = $this->putJson(action([ProductController::class, 'update'], ['product' => $product->id]), [
            'title' => 'updated title',
            'path' => UploadedFile::fake()->image('product3.jpg')
        ]);
        dd($response->json());
        $response->assertSuccessful()
            ->assertJsonPath('data.title', 'updated title');

        Storage::assertExists($response->json('data.path'));
    }

    /** @test */
    public function it_deletes_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(action([ProductController::class, 'destroy'], ['product' => $product->id]));

        $response->assertNoContent();
    }
}
