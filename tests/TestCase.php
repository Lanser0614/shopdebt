<?php

namespace Tests;

use App\Constants\RolesEnum;
use App\Models\Client;
use App\Models\Debt;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected  $owner;
    protected  $seller;
    protected $stranger;
    protected  Client $client;
    protected  Shop $shop;
    protected Debt $debt;
    protected Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create()->assignRole(RolesEnum::OWNER->value);
        $this->seller = User::factory()->create()->assignRole(RolesEnum::SELLER->value);
        $this->stranger = User::factory()->create()->assignRole(RolesEnum::OWNER->value);
    }

    protected function isSuccess(TestResponse $response)
    {
        $this->assertEquals(true, $response->json('success'));
    }

    protected function isNotSuccess(TestResponse $response)
    {
        $this->assertEquals(false, $response->json('success'));
    }
    protected abstract function getJsonStructure(): array;

    protected abstract function getFakeModel($method = 'create', $count = 1): Model|array;

}
