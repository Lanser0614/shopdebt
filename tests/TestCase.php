<?php

namespace Tests;

use App\Constants\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $owner;
    protected $seller;

    public function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create()->assignRole(RolesEnum::OWNER->value);
        $this->seller = User::factory()->create()->assignRole(RolesEnum::SELLER->value);
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
