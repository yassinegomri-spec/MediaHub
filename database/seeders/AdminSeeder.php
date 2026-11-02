<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mediahub.test'],
            [
                'name' => 'Administrateur MediaHub',
                'password' => Hash::make('ChangeMe123!'),
            ]
        );
    }
}
