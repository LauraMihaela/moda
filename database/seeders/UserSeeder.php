<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Se eliminan datos de users por si hubiera
                DB::table('users')->delete();

                DB::table('users')->insert(
                    [
                        [
                            'id' => 1,
                            'username' => 'Laura',
                            'password' => Hash::make(env('ADMIN_INITIAL_PASSWORD')),
                            'name' => 'Laura',
                            'lastname' => 'Gheorghiu',
                            'email' => 'gheorghiulauradw@gmail.com',
                            'remember_token' => null,
                            'role_id' => 3,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ],
                    ]
                );
    }
}
