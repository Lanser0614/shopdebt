<?php

namespace Tests\Feature\Shop;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_shop()
    {
        $shop = $this->getFakeModel();
        $response = $this->withHeader('Accept', 'application/json')
            ->post(route('shops.store'), $shop)
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());

    }
    protected function getJsonStructure(): array
    {
        // TODO: Implement getJsonStructure() method.
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        $users = Shop::factory()->count($count)->$method();
        return $count === 1 ? $users[0] : $users;
    }
}
