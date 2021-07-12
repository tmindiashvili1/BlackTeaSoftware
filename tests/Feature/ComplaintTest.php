<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComplaintTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_required_fields_for_store_client_complaint_data()
    {
        $this->json('POST', 'api/client/complaint/store', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "title" => ["The title field is required."],
                    "text" => ["The text field is required."],
                    "client_id" => ["The client id field is required."],
                    "in_work" => ["The in work field is required."]
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_string_max_length_fields_for_store_client_complaint_data()
    {
        $client = Client::factory(1)->create()->first();

        $faker = \Faker\Factory::create();
        $this->json('POST', 'api/client/complaint/store', [
            'title' => $faker->sentence(1000),
            'text' => $faker->sentence(1000),
            'in_work' => $faker->word(),
            'client_id' => $client->id
        ], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "title" => ["The title must not be greater than 150 characters."],
                    "text" => ["The text must not be greater than 3000 characters."]
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_title_special_chars_for_store_client_complaint_data()
    {
        $client = Client::factory(1)->create()->first();

        $faker = \Faker\Factory::create();
        $this->json('POST', 'api/client/complaint/store', [
            'title' => $faker->sentence(1) . '%!#!@#',
            'text' => $faker->sentence(10),
            'in_work' => $faker->word(),
            'client_id' => $client->id
        ], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "title" => ["The title format is invalid."]
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_client_exists_for_store_client_complaint_data()
    {
        $faker = \Faker\Factory::create();
        $this->json('POST', 'api/client/complaint/store', [
            'title' => $faker->words(10, true),
            'text' => $faker->sentence(10),
            'in_work' => $faker->word(),
            'client_id' => $faker->numberBetween(1000, 2000)
        ], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "client_id" => ["The selected client id is invalid."]
                ]
            ]);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_store_client_complaint_data()
    {
        $client = Client::factory(1)->create()->first();
        $faker = \Faker\Factory::create();
        $this->json('POST', 'api/client/complaint/store', [
            'title' => $faker->words(10, true),
            'text' => $faker->sentence(10),
            'in_work' => $faker->word(),
            'client_id' => $client->id
        ], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'complaint' => [
                        'id',
                        'title',
                        'text',
                        'client_id',
                        'in_work',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_no_clients_found_client_complaints_list()
    {
        $this->json('GET', 'api/client/complaint', [
            'client_id' => 12312312
        ], ['Accept' => 'application/json'])
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function test_get_success_client_complaints_list()
    {
        $client = Client::factory(1)->create()->first();
        $this->json('GET', 'api/client/complaint', [
            'client_id' => $client->id,
        ], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'address',
                    'created_at',
                    'updated_at',
                    'complaints' => [
                        '*' => [
                            'id',
                            'title',
                            'text',
                            'client_id',
                            'in_work',
                            'created_at',
                            'updated_at'
                        ]
                    ]

                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_required_fields_for_update_client_complaint_data()
    {
        $client = Client::factory(1)->create()->first();
        $this->json('PUT', 'api/client/complaint/' . $client->id, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "in_work" => ["The in work field is required."]
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_no_complaint_found_for_update_client_complaint_data()
    {
        $faker = \Faker\Factory::create();
        $this->json('PUT', 'api/client/complaint/12312312312312', [
            'in_work' => $faker->words
        ], ['Accept' => 'application/json'])
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function test_success_for_update_client_complaint_data()
    {
        $client = Complaint::factory(1)->create()->first();
        $faker = \Faker\Factory::create();
        $this->json('PUT', 'api/client/complaint/' . $client->id, [
            'in_work' => $faker->words
        ], ['Accept' => 'application/json'])
            ->assertStatus(200)->assertJsonStructure([
                'data' => [
                    'complaint' => [
                        'id',
                        'title',
                        'text',
                        'client_id',
                        'in_work',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

}
