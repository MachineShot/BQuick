<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Banker',
            'email' => 'bank@bank.com',
            'password' => bcrypt('bank1234'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Outpatient Clinic',
            'email' => 'clinic@clinic.com',
            'password' => bcrypt('clinic1234'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Post Office',
            'email' => 'post@post.com',
            'password' => bcrypt('post1234'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Service',
            'email' => 'service@service.com',
            'password' => bcrypt('service1234'),
        ]);
    }
}
