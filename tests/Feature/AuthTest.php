<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create(['password' => 'password123']);
    }

    public function test_user_can_login()
    {
        $this->owner->password = 'password123';
        $response = $this->withHeader('Accept', 'application/json')
            ->post(route('login'),['email' => $this->owner->email, 'password' => 'password123'])
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
        $this->assertEquals($this->owner->id, $response->json('data.user.id'));
    }

    public function test_user_can_logout()
    {
        $token = $this->post(route('login'), ['email' => $this->owner->email, 'password' => 'password123'])
            ->json('data.token');
        $response = $this->withToken($token)
            ->get(route('logout'))
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'success']);
        $this->isSuccess($response);
    }

    public function test_user_can_register()
    {
        $data = $this->getFakeModel('raw');
        $data['password_confirmation'] = $data['password'];
        $response = $this->post(route('register'), $data)
            ->assertStatus(200)
            ->assertJsonStructure($this->getJsonStructure());
        $this->isSuccess($response);
    }

    public function test_user_can_generate_otp()
    {
        $response = $this->post(route('otp.generate'), ['email' => $this->owner->email])
            ->assertStatus(200);
//        $this->isSuccess($response);
//        $otp = $response->json('otp');
//        $model = VerificationCode::query()->orderBy('id', 'desc')->first();
//        $this->assertEquals($model->user_id, $this->owner->id);
//        $this->assertEquals($model->otp, $otp);
    }

//    public function test_user_can_login_with_otp()
//    {
//        $otp = $this->post(route('otp.generate'), ['email' => $this->owner->email])->json('otp');
//        $response = $this->post(route('otp.login'), ['user_id' => $this->owner->id, 'otp' => $otp])
//        ->assertStatus(200);
//        $this->isSuccess($response);
//    }

    protected function getJsonStructure(): array
    {
        return [
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'phone_number'
                ],
                'token_type',
                'token'
            ],
            'message',
            'success'
        ];
    }

    protected function getFakeModel($method = 'create', $count = 1): Model|array
    {
        $users = User::factory()->count($count)->$method();
        return $count === 1 ? $users[0] : $users;
    }
}
