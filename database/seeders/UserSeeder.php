<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' =>'Leonardo',
            'email' =>'leo@teste.com' ,
            'password' => '$2y$10$FBt9Qp6WJE4BdecTsZOsTOemsQds3kGvgEB3V8s.c0NTCNjRMwJxm',
        ]);
    }
}
