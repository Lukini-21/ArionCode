<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('projects')->count()) {
            return;
        }
        $faker = Faker::create();

        $statuses = ['active', 'planning', 'completed', 'hold'];

        foreach (DB::table('organizations')->get() as $org) {
            foreach (range(1, rand(2, 5)) as $i) {
                DB::table('projects')->insert([
                    'organization_id' => $org->id,
                    'name' => $faker->catchPhrase(),
                    'is_public' => $faker->randomElement([true, false]),
                    'description' => $faker->sentence(8),
                    'status' => $faker->randomElement($statuses),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
