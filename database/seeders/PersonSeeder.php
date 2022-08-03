<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\PersonModel;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Person::create([
            'name' => 'Admin',
            'last_father_name' => "Sysadmin",
            'last_mother_name' => 'Sysadmin',
            'gender' => 'U',
            'birth_date' => Date(now()), 
            'is_active' => true,
            'created_by' => 0,
            'updated_by' => null,
        ]);
    }
}
