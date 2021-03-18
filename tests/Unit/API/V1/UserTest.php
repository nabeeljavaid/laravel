<?php

namespace Tests\Unit\API\V1;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\User;
use Str;


class UserTest extends TestCase
{
    /**
     * Test Get All Users
     *
     * @return void
     */
    public function test_index() {
   
   		$response = $this->json('GET', '/api/v1/users');

   		$response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
            	'data' => [
            		'*' => [ 'id', 'name', 'email' ]
            	]
            ]);
            
    }

    /**
     * Test Save User
     *
     * @return void
     */
    public function test_store() {
   		
   		$user = User::factory()->make();
   		$response = $this->json('POST', '/api/v1/users', [
   			'name' => $user->name,
   			'email' => $user->email,
   			'password' => Str::random(8)
   		]);

   		$response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => true,
            ]);
            
    }

    /**
     * Test Get User By ID
     *
     * @return void
     */
    public function test_show() {
   		
   		$user = User::factory()->create();
   		$response = $this->json('GET', '/api/v1/users/' . $user->id);

   		$response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
            	'data' => ['id', 'name', 'email']
            ]);
            
    }

    /**
     * Test Update User
     *
     * @return void
     */
    public function test_update() {
   		
   		$user = User::factory()->create();
   		$response = $this->json('PUT', '/api/v1/users/' . $user->id, [
   			'name' => $user->name,
   			'email' => $user->email,
   			'password' => Str::random(8)
   		]);

   		$response
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson([
                'message' => true,
            ]);
            
    }

    /**
     * Test Remove User
     *
     * @return void
     */
    public function test_destroy() {
   		
   		$user = User::factory()->create();
   		$response = $this->json('DELETE', '/api/v1/users/' . $user->id);

   		$response
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson([
                'message' => true,
            ]);
            
    }
}
