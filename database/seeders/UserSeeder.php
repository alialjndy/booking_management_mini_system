<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email'=> 'alialjndy2@gmail.com',
            'password'=> Hash::make('strongPass123@'),
            'phone_number' =>'0998680361'
        ]);
        $staff = User::create([
            'name' => 'staff',
            'email'=> 'staff@gmail.com',
            'password'=> Hash::make('strongPass123@'),
            'phone_number' =>'09900000000'
        ]);
        $admin->assignRole('admin');
        $staff->assignRole('staff');
    }
}
