<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('organizations')->count()) {
            return;
        }
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            DB::table('organizations')->insert([
                'name' => $faker->company(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
