<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('notifications')->count()) {
            return;
        }
        $faker = Faker::create();

        $tasks = DB::table('tasks')->get();

        $notifications = collect(range(1, 50))->map(function () use ($faker, $tasks) {
            $task = $tasks->random();
            return [
                'user_id' => rand(1, 15),
                'message' => "Update on task: {$task->title} — {$faker->sentence(5)}",
                'read_at' => rand(0, 1) ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        DB::table('notifications')->insert($notifications->toArray());
    }
}
