<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_required_fields_for_store_client_data()
    {
        $this->json('POST', 'api/client/store', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "address" => ["The address field is required."]
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_string_max_length_fields_for_store_client_data()
    {
        $faker = \Faker\Factory::create();
        $this->json('POST', 'api/client/store', [
            'name' => $faker->sentence(10000),
            'address' => $faker->sentence(2000)
        ], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name must not be greater than 200 characters."],
                    "address" => ["The address must not be greater than 1000 characters."]
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_store_client_data()
    {
        $faker = \Faker\Factory::create();
        $this->json('POST', 'api/client/store', [
            'name' => $faker->sentence(5),
            'address' => $faker->sentence(20)
        ], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'client' => [
                        'id',
                        'name',
                        'address',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

}
