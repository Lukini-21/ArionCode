<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('tasks')->count()) {
            return;
        }
        $faker = Faker::create();

        $statuses = ['todo', 'in_progress', 'done', 'backlog', 'review', 'blocked'];
        $priorities = ['low', 'medium', 'high', 'critical'];

        foreach (DB::table('projects')->get() as $project) {
            foreach (range(1, rand(3, 8)) as $i) {
                DB::table('tasks')->insert([
                    'project_id' => $project->id,
                    'title' => $faker->sentence(4),
                    'status' => $faker->randomElement($statuses),
                    'priority' => $faker->randomElement($priorities),
                    'description' => $faker->sentence(8),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
