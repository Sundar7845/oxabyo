<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'key' => 'admin',
            'name' => 'Administrator'
        ]);

        Role::create([
            'key' => 'user',
            'name' => 'User'
        ]);
    }
}
