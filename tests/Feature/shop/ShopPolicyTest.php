<?php

namespace Tests\Feature\shop;

use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['user_id' => $this->owner->id]);
        $this->seller->seller = Seller::factory()->create(['shop_id' => $this->shop->id]);
    }

    public function test_owner_can_access_create_route()
    {
        $shop = $this->getFakeModel('raw');
        $response = $this->actingAs($this->owner)
            ->post(route('shops.store'), $shop)
            ->assertStatus(201);
        $this->isSuccess($response);
    }

    public function test_seller_cannot_access_create_route()
    {
        $shop = $this->getFakeModel('raw');
        $response = $this->actingAs($this->seller)
            ->post(route('shops.store'), $shop)
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_guest_cannot_access_create_route()
    {
        $shop = $this->getFakeModel('raw');
        $response = $this->withHeader('Accept', 'application/json')
            ->post(route('shops.store'), $shop)
            ->assertStatus(401);
        $this->isNotSuccess($response);
    }

    /*------------------------------------------------------------Update route------------------------------------------------------------*/

    public function test_owner_can_access_update_route()
    {
        $response = $this->actingAs($this->owner)
            ->put(route('shops.update', $this->shop->id), ['name' => 'Updated'])
            ->assertStatus(200);
        $this->isSuccess($response);
    }

    public function test_seller_cannot_access_shop_update_route()
    {
        $response = $this->actingAs($this->seller)
            ->put(route('shops.update', $this->shop->id), ['name' => 'Updated'])
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_stranger_cannot_access_update_route()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->actingAs($this->stranger)
            ->put(route('shops.update', $this->shop->id), ['name' => 'Updated'])
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_guest_cannot_access_update_route()
    {
        $response = $this->withHeader("Accept", 'application/json')
            ->put(route('shops.update', $this->shop->id), ['name' => 'Updated'])
            ->assertStatus(401);
        $this->isNotSuccess($response);
    }

    /*----------------------------------------------------------Delete route-------------------------------------------------------------*/

    public function test_owner_can_access_delete_route()
    {
        $response = $this->actingAs($this->owner)
            ->delete(route('shops.destroy', $this->shop->id))
            ->assertStatus(200);
        $this->isSuccess($response);
    }

    public function test_seller_cannot_access_delete_route()
    {
        $response = $this->actingAs($this->seller)
            ->delete(route('shops.destroy', $this->shop->id))
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_stranger_cannot_access_delete_route()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->actingAs($this->stranger)
            ->delete(route('shops.destroy', $this->shop->id))
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_guest_cannot_access_delete_route()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->delete(route('shops.destroy', $this->shop->id))
            ->assertStatus(401);
        $this->isNotSuccess($response);
    }

    /*-------------------------------------------------------Shop seller route-------------------------------------------------*/

    public function test_owner_can_access_shop_sellers_route()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('shop-sellers', $this->shop->id))
            ->assertStatus(200);
        $this->isSuccess($response);
    }

    public function test_seller_cannot_access_shop_sellers_route()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('shop-sellers', $this->shop->id))
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_stranger_cannot_access_shop_sellers_route()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->actingAs($this->stranger)
            ->get(route('shop-sellers', $this->shop->id))
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    public function test_guest_cannot_access_shop_sellers_route()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->get(route('shop-sellers', $this->shop->id))
            ->assertStatus(401);
        $this->isNotSuccess($response);
    }

    /*---------------------------------------------------------Shop clients route-------------------------------------------------*/

    public function test_owner_can_access_shop_clients_route()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('shop-clients', $this->shop->id))
            ->assertStatus(200);
        $this->isSuccess($response);
    }

    public function test_seller_can_access_shop_clients_route()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('shop-clients', $this->shop->id))
            ->assertStatus(200);
        $this->isSuccess($response);
    }

    public function test_stranger_cannot_access_shop_clients_route()
    {
        $response = $this->withHeader('Accept', 'application/json')
            ->actingAs($this->stranger)
            ->get(route('shop-clients', $this->shop->id))
            ->assertStatus(403);
        $this->isNotSuccess($response);
    }

    protected function getJsonStructure(): array
    {
        return  [];
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        $shop = Shop::factory()->count($count)->$method();
        return $count === 1 ? $shop[0] : $shop;
    }
}
