<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['user_id' => $this->owner->id]);
        $this->seller->seller = Seller::factory()->create(['shop_id' => $this->shop->id]);
        $this->client = Client::factory()->create(['shop_id' => $this->shop->id]);
    }

    public function test_owner_can_create_client()
    {
        $client = $this->getFakeModel('raw');
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), $client)
            ->assertStatus(201)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $id = $response->json('data.id');
        $this->assertDatabaseHas('clients', ['id' => $id]);
    }

    public function test_seller_can_create_seller()
    {
        $client = $this->getFakeModel('raw');
        $response = $this->actingAs($this->seller)
            ->post(route('clients.store'), $client)
            ->assertStatus(201)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $id = $response->json('data.id');
        $this->assertDatabaseHas('clients', ['id' => $id]);
    }

    public function test_owner_can_see_client()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('clients.show', $this->client->id))
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_seller_can_see_client()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('clients.show', $this->client->id))
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_owner_can_update_seller()
    {
        $response = $this->actingAs($this->owner)
            ->put(route('clients.update', $this->client->id), ['name' => 'Updated'])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $client = Client::find($this->client->id)->toArray();
        $this->assertEquals('Updated', $client['name']);
    }

    public function test_seller_can_update_client()
    {
        $response = $this->actingAs($this->seller)
            ->put(route('clients.update', $this->client->id), ['name' => 'Updated'])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $client = Client::find($this->client->id)->toArray();
        $this->assertEquals('Updated', $client['name']);
    }

    public function test_owner_can_delete_client()
    {
        $response = $this->actingAs($this->owner)
            ->delete(route('clients.destroy', $this->client->id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
        $this->assertDatabaseMissing('clients', ['id' => $this->client->id]);
    }

    public function test_seller_can_delete_client()
    {
        $response = $this->actingAs($this->owner)
            ->delete(route('clients.destroy', $this->client->id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
        $this->assertDatabaseMissing('clients', ['id' => $this->client->id]);
    }
    
    protected function getJsonStructure(): array
    {
        return [
            'data' => [
                'id', 'shop', 'name', 'phone', 'address'
            ],
            'message',
            'success'
        ];
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        $client = Client::factory()->count($count)->$method();
        return $count === 1 ? $client[0] : $client;
    }
}
