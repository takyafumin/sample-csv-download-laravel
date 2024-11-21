<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->city(),
            'description' => $this->faker->address(),
            'status' => $this->faker->randomElement(['pending', 'completed']),
        ];
    }
}
