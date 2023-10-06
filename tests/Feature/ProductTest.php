<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['user_id' => $this->owner->id]);
        $this->seller->seller = Seller::factory()->create(['shop_id' => $this->shop->id]);
        $this->product = Product::factory()->create(['shop_id' => $this->shop->id]);
    }

    public function test_owner_can_create_product()
    {
        $raw = $this->getFakeModel('raw');
        $response = $this->actingAs($this->owner)->post(route('products.store'), $raw)
            ->assertStatus(201)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertDatabaseHas('products', ['id' => $response->json('data.id')]);
    }

    public function test_seller_can_create_product()
    {
        $raw = $this->getFakeModel('raw');
        $response = $this->actingAs($this->seller)->post(route('products.store'), $raw)
            ->assertStatus(201)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertDatabaseHas('products', ['id' => $response->json('data.id')]);
    }

    public function test_owner_can_see_product()
    {
        $response = $this->actingAs($this->owner)->get(route('products.show', $this->product->id))
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_seller_can_see_product()
    {
        $response = $this->actingAs($this->owner)->get(route('products.show', $this->product->id))
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_owner_can_update_product()
    {
        $response = $this->actingAs($this->owner)->put(route('products.update', $this->product->id), ['name' => 'Palpy'])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertEquals('Palpy', $response->json('data.name'));
    }

    public function test_seller_can_update_product()
    {
        $response = $this->actingAs($this->seller)->put(route('products.update', $this->product->id), ['name' => 'Palpy'])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertEquals('Palpy', $response->json('data.name'));
    }

    public function test_owner_can_delete_product()
    {
        $id = $this->product->id;
        $response = $this->actingAs($this->owner)->delete(route('products.destroy', $id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
        $this->assertDatabaseMissing('products', ['id' => $id]);
    }

    public function test_seller_can_delete_product()
    {
        $id = $this->product->id;
        $response = $this->actingAs($this->seller)->delete(route('products.destroy', $id))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
        $this->assertDatabaseMissing('products', ['id' => $id]);
    }


    protected function getJsonStructure(): array
    {
        return [
          'data' => [
              'id',
              'shop',
              'name',
              'price',
              'description'
          ],
          'message',
          'success'
        ];
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        $product = Product::factory()->count($count)->$method(['shop_id' => $this->shop->id]);
        return $count === 1 ? $product[0] : $product;
    }
}
