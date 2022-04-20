<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        User::factory()
            ->count(1)
            ->create();
        */
        User::query()->firstOrCreate([
            'name' => 'chen sheng',
            'email' => 'liber@shawly.cn',
            'email_verified_at' => Carbon::now(),
            //'password'=> Hash::make('123456'),
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
        ]);
    }
}
