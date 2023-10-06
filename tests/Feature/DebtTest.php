<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Debt;
use App\Models\Seller;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebtTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['user_id' => $this->owner->id]);
        $this->seller->seller = Seller::factory()->create(['shop_id' => $this->shop->id]);
        $this->client = Client::factory()->create(['shop_id' => $this->shop->id]);
        $this->debt = Debt::factory()->create(['shop_id' => $this->shop->id, 'user_id' => $this->owner->id, 'client_id' => $this->client->id]);
    }

    public function test_owner_can_create_debt()
    {
        $raw = $this->getFakeModel('raw');
        $response = $this->actingAs($this->owner)->post(route('debts.store'), $raw)
                ->assertStatus(201)
                ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_seller_can_create_debt()
    {
        $raw = $this->getFakeModel('raw');
        $response = $this->actingAs($this->seller)->post(route('debts.store'), $raw)
            ->assertStatus(201)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_owner_can_see_debt()
    {
        $response = $this->actingAs($this->owner)->get(route('debts.show', $this->debt->id))
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_seller_can_see_debt()
    {
        $response = $this->actingAs($this->seller)->get(route('debts.show', $this->debt->id))
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_owner_can_update_debt()
    {
        $response = $this->actingAs($this->owner)->put(route('debts.update', $this->debt->id), ['amount' => 221000])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertEquals($response->json('data.amount'),221000);
    }

    public function test_seller_can_update_debt()
    {
        $response = $this->actingAs($this->seller)->put(route('debts.update', $this->debt->id), ['amount' => 221000])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertEquals($response->json('data.amount'),221000);
    }

    public function test_owner_can_delete_debt()
    {
        $response = $this->actingAs($this->owner)->delete(route('debts.destroy', $this->debt->id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
    }

    public function test_seller_can_delete_debt()
    {
        $response = $this->actingAs($this->seller)->delete(route('debts.destroy', $this->debt->id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
    }

    public function test_owner_can_search_debts()
    {
        $debt = Debt::factory()->create(['client_id' => 2]);
        $response = $this->actingAs($this->owner)->get(route('search-debt', ['client_id' => 2]))
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'comment', 'amount', 'deadline']], 'message', 'success']);
        $this->isSuccess($response);
        $this->assertEquals(2, $response['data'][0]['id']);
    }
    protected function getJsonStructure(): array
    {

        return [
            'data' => [
                'id', 'shop', 'seller', 'client', 'comment', 'amount', 'deadline'
            ],
            'message',
            'success'
        ];
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {

        $debt = Debt::factory()->count($count)
            ->$method(['shop_id' => $this->shop->id, 'user_id' => $this->owner->id, 'client_id' => $this->client->id, 'deadline' => Carbon::now()]);
        return $count === 1 ? $debt[0] : $debt;
    }
}
