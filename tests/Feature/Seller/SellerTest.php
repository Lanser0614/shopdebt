<?php

namespace Tests\Feature\Seller;

use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerTest extends TestCase
{

    use RefreshDatabase;

    protected Seller $manager;
    public function setUp():void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['user_id' => $this->owner->id]);
        $this->seller->seller = Seller::factory()->create(['shop_id' => $this->shop->id]);
    }

    public function test_owner_can_create_seller()
    {
        $response = $this->actingAs($this->owner)
            ->post(route('seller.store'), ['shop_id' => $this->shop->id, 'label' => 'Manager'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' =>
                ['activation_code'],
                'message',
                'success']);
        $this->isSuccess($response);
    }

    public function test_seller_can_activate()
    {
        $seller =  $this->actingAs($this->owner)->post(route('seller.store'), ['shop_id' => $this->shop->id, 'label' => 'Manager']);
        $code = $seller->json('data.activation_code');
        $response = $this->actingAs($this->seller)
            ->post(route('seller.activate'), ['activation_code' => $code])
            ->assertStatus(200);
        $this->isSuccess($response);
    }

    public function test_owner_can_delete_seller()
    {
        $id = $this->seller->seller->id;
        $response = $this->actingAs($this->owner)
            ->delete(route('seller.destroy', $id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
        $this->assertDatabaseMissing('sellers', ['id' => $this->seller->id]);
    }

    protected function getJsonStructure(): array
    {
        // TODO: Implement getJsonStructure() method.
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        // TODO: Implement getFakeModel() method.
    }
}
