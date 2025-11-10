<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrganizationUserSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('organization_users')->count()) {
            return;
        }
        $faker = Faker::create();

        $users = array_column(config('demo.users'), 'uuid');
        $orgs = DB::table('organizations')->get();

        foreach ($orgs as $org) {
            foreach ($faker->randomElements($users, rand(3, 6)) as $userUuid) {
                DB::table('organization_users')->insert([
                    'organization_id' => $org->id,
                    'user_id' => $userUuid,
                    'role' => $faker->randomElement(['member', 'manager', 'admin']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
