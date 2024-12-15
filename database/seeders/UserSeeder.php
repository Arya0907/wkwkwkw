<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\staff_provinces;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email'=> 'test@gmail.com',
            'password' => hash::make('test1234'),
            'role' => 'GUEST',
        ]);
        $staff=User::create([
            'email'=> 'staff@gmail.com',
            'password' => hash::make('staff1234'),
            'role' => 'STAFF',
        ]);
        User::create([
            'email'=> 'head_staff@gmail.com',
            'password' => hash::make('head_staff1234'),
            'role' => 'HEAD_STAFF',
        ]);

        staff_provinces::create([
            'user_id' => $staff->id, // Mengambil ID user yang baru dibuat
            'province' => 'Jawa Barat',
        ]);

        
    }
}
