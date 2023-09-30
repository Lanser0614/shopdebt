<?php

namespace Tests\Feature\Shop;

use App\Models\Client;
use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['user_id' => $this->owner->id]);
        $this->seller = Seller::factory()->create(['shop_id' => $this->shop->id]);
        $this->client = Client::factory()->create(['shop_id' => $this->shop->id]);
    }
    public function test_user_can_create_shop()
    {
        $shop = $this->getFakeModel('raw');
        $response = $this->actingAs($this->owner)
            ->post(route('shops.store'), $shop)
            ->assertStatus(201)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_user_can_update_shop()
    {
        $response = $this->actingAs($this->owner)
            ->withHeader('Accept', 'application/json')
            ->put(route('shops.update', $this->shop->id), ['name' => 'Updated'])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $name = $response->json('data.name');
        $model = Shop::find($this->shop->id)->toArray();
        $this->assertEquals($model['name'], $name);
    }

    public function test_user_can_delete_shop()
    {
        $response = $this->actingAs($this->owner)
            ->delete(route('shops.destroy', $this->shop->id))
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'success',
            ]);
        $this->isSuccess($response);
        $this->assertDatabaseMissing('shops', ['id' => $this->shop->id]);
    }

    public function test_owner_can_see_shop_sellers()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('shop-sellers', $this->shop->id))
            ->assertStatus(200)
            ->assertJsonStructure([
               'data' => [['user','shop', 'label']],
                'message',
                'success'
            ]);
        $this->isSuccess($response);
    }

    public function test_owner_can_see_shop_client()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('shop-clients', $this->shop->id))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'name', 'phone', 'address']],
                'message',
                'success'
            ]);
        $this->isSuccess($response);
    }

    protected function getJsonStructure(): array
    {
        return  [
            'data' => ['id', 'name', 'address', 'owner'],
            'message',
            'success'
            ];
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        $shop = Shop::factory()->count($count)->$method();
        return $count === 1 ? $shop[0] : $shop;
    }
}
