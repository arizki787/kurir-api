<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Courier;

class CourierControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index_sorts_by_name_by_default()
    {
        Courier::factory()->create(['name' => 'Budi']);
        Courier::factory()->create(['name' => 'Agus']);

        $response = $this->getJson('/api/couriers');
        $response->assertOk();
        $this->assertEquals('Agus', $response->json('data.0.name'));
    }

    public function test_index_can_sort_by_joined_at()
    {
        Courier::factory()->create(['name' => 'Zeta', 'joined_at' => now()->subDays(1)]);
        Courier::factory()->create(['name' => 'Alpha', 'joined_at' => now()->subDays(10)]);

        $response = $this->getJson('/api/couriers?sort_by=joined_at');
        $this->assertEquals('Alpha', $response->json('data.0.name'));
    }

    public function test_index_can_search_by_partial_name_terms()
    {
        Courier::factory()->create(['name' => 'Budiono Hadi Agung']);
        Courier::factory()->create(['name' => 'Siti Aminah']);

        $response = $this->getJson('/api/couriers?search=budi+agung');
        $response->assertOk()->assertJsonCount(1, 'data');
        $this->assertEquals('Budiono Hadi Agung', $response->json('data.0.name'));
    }

    public function test_index_can_filter_by_multiple_levels()
    {
        Courier::factory()->create(['level' => 1]);
        Courier::factory()->create(['level' => 2]);
        Courier::factory()->create(['level' => 3]);
        Courier::factory()->create(['level' => 4]);

        $response = $this->getJson('/api/couriers?level=2,3');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_index_paginates_results()
    {
        Courier::factory()->count(20)->create();

        $response = $this->getJson('/api/couriers?per_page=5');
        $response->assertOk()->assertJsonCount(5, 'data');
        $this->assertEquals(20, $response->json('meta.total'));
    }

    public function test_show_returns_courier_data()
    {
        $courier = Courier::factory()->create();
        $this->getJson("/api/couriers/{$courier->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $courier->id);
    }

    public function test_store_saves_courier_to_database()
    {
        $payload = Courier::factory()->make()->toArray();
        $payload['joined_at'] = now()->toDateString();

        $this->postJson('/api/couriers', $payload)->assertCreated();
        $this->assertDatabaseHas('couriers', ['email' => $payload['email']]);
    }

    public function test_store_fails_validation_for_invalid_level()
    {
        $payload = Courier::factory()->make(['level' => 9])->toArray();
        $this->postJson('/api/couriers', $payload)->assertUnprocessable();
    }

    public function test_update_saves_changes_to_database()
    {
        $courier = Courier::factory()->create(['name' => 'Old Name']);
        $this->putJson("/api/couriers/{$courier->id}", ['name' => 'New Name'])
            ->assertOk();
        $this->assertDatabaseHas('couriers', ['id' => $courier->id, 'name' => 'New Name']);
    }

    public function test_destroy_removes_courier_from_database()
    {
        $courier = Courier::factory()->create();
        $this->deleteJson("/api/couriers/{$courier->id}")->assertNoContent();
        $this->assertDatabaseMissing('couriers', ['id' => $courier->id]);
    }
}
