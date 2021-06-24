<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
        ];
    }

    public function archived()
    {
        return $this->state([
            'is_archived' => true,
        ]);
    }

    public function unarchived()
    {
        return $this->state([
            'is_archived' => false,
        ]);
    }
}