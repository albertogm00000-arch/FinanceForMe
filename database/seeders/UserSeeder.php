<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@financefor.me',
            'password' => Hash::make('password'),
        ]);

        // Crear cuentas de ejemplo
        Account::create([
            'user_id' => $user->id,
            'name' => 'Cuenta Corriente',
            'type' => 'bank',
            'balance' => 1500.00,
            'currency' => 'EUR'
        ]);

        Account::create([
            'user_id' => $user->id,
            'name' => 'Efectivo',
            'type' => 'cash',
            'balance' => 200.00,
            'currency' => 'EUR'
        ]);
    }
}