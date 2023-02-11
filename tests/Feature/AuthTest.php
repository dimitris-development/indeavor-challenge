<?php

namespace Tests\Feature;

use App\Http\Resources\LoggedInUserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * @var array
     */
    private $routes;

    /**
     * Setup the test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->routes = [
            'login' => '/api/login',
            'logout' => '/api/logout',
        ];
    }

    /**
     * A user can login successfully.
     *
     * @return void
     */
    public function testAUserCanLoginSuccessfully()
    {
        $user = User::factory(['password' => Hash::make('123456')])->create();

        $request = [
            'email' => $user->email,
            'password' => '123456',
        ];

        $response = $this
            ->json('POST', $this->routes['login'], $request)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'avatar_url',
                    'created_at',
                ],
                'token' => [
                    'access_token',
                    'type',
                ],
            ])
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'avatar_url' => null,
                ],

            ]);

        $this->assertInstanceOf(LoggedInUserResource::class, $response->getOriginalContent());
    }

    /**
     * A user can not login without required input.
     *
     * @return void
     */
    public function testAUserCanNotLoginWithoutRequiredInput()
    {
        $this
            ->json('POST', $this->routes['login'], [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrorFor('email')
            ->assertJsonValidationErrorFor('password');
    }

    /**
     * A user can not login with invalid credentials.
     *
     * @return void
     */
    public function testAUserCanNotLoginWithInvalidCredentials()
    {
        $user = User::factory(['password' => Hash::make('123456')])->create();

        $request = [
            'email' => $user->email,
            'password' => $this->faker->password(),
        ];

        $this
            ->json('POST', $this->routes['login'], $request)
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Invalid credentials.',
            ]);
    }

    /**
     * A user can logout successfully.
     *
     * @return void
     */
    public function testAUserCanLogoutSuccessfully()
    {
        Sanctum::actingAs(User::factory()->create(), [], 'user');

        $this->json('POST', $this->routes['logout'])
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
