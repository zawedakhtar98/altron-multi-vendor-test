<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>ucfirst($this->faker->unique()->word()),
            'sub_category' => null,
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the category is a sub-category.
     */
    public function subCategory($parentId)
    {
        return $this->state(function () use ($parentId) {
            return [
                'sub_category' => $parentId,
            ];
        });
    }
}
