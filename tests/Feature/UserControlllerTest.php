<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControlllerTest extends TestCase
{
    /** @test */
    public function it_shows_users()
    {
        $user = User::factory(10)->create();

        $response = $this->getJson(action([UserController::class, 'index']));
        $response->assertOk()
            ->assertJsonCount(10);
    }
    /** @test */
    public function it_creates_user()
    {
        $user = User::factory()->raw();

        $response = $this->postJson(action([UserController::class, 'store']), $user);

        $response->assertCreated();
    }
    /** @test */
    public function it_update_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson(action([UserController::class, 'update'], ['user' => $user->id]), [
            'name' => 'new name',
            'password' => '123456789',
            'email' => 'updated@email.com'
        ]);
        $response->assertSuccessful()
            ->assertJsonFragment(['name' => 'new name']);
    }
    /** @test */
    public function it_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->postJson(action([UserController::class, 'destroy'], ['user' => $user->id]));

        $response->assertNoContent();
    }
}
