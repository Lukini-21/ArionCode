<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectMemberSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('project_members')->count()) {
            return;
        }
        $faker = Faker::create();

        $projects = DB::table('projects')->get();

        foreach ($projects as $project) {
            $orgUserIds = DB::table('organization_users')
                ->where('organization_id', $project->organization_id)
                ->pluck('user_id')
                ->toArray();

            foreach ($faker->randomElements($orgUserIds, min(count($orgUserIds), rand(2, 5))) as $userUuid) {
                DB::table('project_members')->insert([
                    'project_id' => $project->id,
                    'user_id' => $userUuid,
                    'role' => $faker->randomElement(['member', 'manager']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
