<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a test user
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // User::factory(99)->create();

        // Create Projects and Tasks
        Project::factory(10000)
            ->create()
            ->each(function ($project) {
                Task::factory(rand(5, 10))
                    ->create(['project_id' => $project->id]);
            });
    }
}
