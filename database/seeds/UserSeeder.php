<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'             => 'Admin',
                'username'         => 'Admin',
                'surename'         => 'Oxabyo',
                'email'            => 'admin@oxabyo.com',
                'password'         => 'Password12$',
                'dob'              => '1990-01-01',
                'user_role_id'     => 1
            ],
            [
                'name'             => 'User',
                'username'         => 'User',
                'surename'         => 'Oxabyo',
                'email'            => 'user@oxabyo.com',
                'password'         => 'Password12$',
                'dob'              => '1990-01-01',
                'user_role_id'     => 2
            ]
        ];

        foreach ($users as $entity) {
            $user = $this->createUser($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createUser($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->surename = $data['surename'];
        $user->email =  $data['email'];
        $user->password = $data['password'];
        $user->dob = $data['dob'];
        $user->user_role_id = $data['user_role_id'];
        $user->activated = 1;
        $user->save();

        return $user;
    }
}
