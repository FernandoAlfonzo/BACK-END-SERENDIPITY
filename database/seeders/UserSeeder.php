<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
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
        $admin=User::create([
        'id_person' => 1,
        'email' => 'admin@admin',
        'password' => Hash::make('itsolution'),
        'email_verified_at' => null,
        'status' => 1,
        'is_active' => true,
        'id_adm_organization' => null,
        'created_at' => Date(now()),
        'created_by' => 0,
        ]);
    }
}
