<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Complaint;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Complaint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $client = Client::factory(1)->create()->first();
        return [
            'title' => $this->faker->words(10, true),
            'text' => $this->faker->sentence(10),
            'in_work' => $this->faker->word(),
            'client_id' => $client->id,
        ];
    }
}
