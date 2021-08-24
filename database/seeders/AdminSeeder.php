<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::where('user_role',User::ADMIN)->first()){
            User::create([
                'name' => 'admin',
                'user_name' => 'admin',
                'registered_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'email' => 'admin@admin.com',
                'password' => Hash::make('Pakistan')
            ]);
        }
    }
}
