<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'password' => Hash::make('password'),
            ]
        ];

        DB::table('users')->insert($data);
    }
}
