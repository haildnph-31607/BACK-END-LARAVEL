<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            "username" => "admin",
            "name" => "Admin",
            "email" => "nguyenminhkhong2004@gmail.com",
            "password" => Hash::make("haitoi2004"),
            "departments_id" => "1",
            "status_id" => "1"

        ]);
    }
}
