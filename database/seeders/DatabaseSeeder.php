<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(3)->create();



        \App\Models\User::factory()->create([
            'role' => 1,
            'name' => "Administrator",
            'email' => "admin@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        

        \App\Models\Department::factory()->create([
            'department_name' => 'ETEEAP Department',
            'status' => 1,
        ]);
        \App\Models\Department::factory()->create([
            'department_name' => 'ETEEAP Assessor',
            'status' => 1,
        ]);
        \App\Models\User::factory()->create([
            'role' => 2,
            'department_id'=>1,
            'isReceiver'=>true,
            'name' => "ETEEAP",
            'email' => "eteeap@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\Course::factory()->create([
            'available_course'=> 'ETEEAP Director'
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Business Administration major in Marketing Management'
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Business Administration major in Financial Management '
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Business Administration major in Human Resource Management '
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Business Administration major in Operations Management '
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Hospitality Management '
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Tourism Management '
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor of Science in Computer Science '
        ]);
        \App\Models\Course::factory()->create([
            'available_course'=> 'Bachelor in Elementary Education'
        ]);
        // // test account
        \App\Models\User::factory()->create([
            'role' => false,
            'name' => "Test Account 1",
            'email' => "user1@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'role' => false,
            'name' => "Test Account 2",
            'email' => "user2@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
