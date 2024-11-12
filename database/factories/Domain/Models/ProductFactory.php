<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->numerify('##########'),
            'product_name' => $this->faker->word,
            'status' => 'draft',
            'quantity' => $this->faker->randomElement(['100ml', '500ml', '1L']),
            'brands' => $this->faker->company,
            'categories' => $this->faker->word,
        ];
    }
}
