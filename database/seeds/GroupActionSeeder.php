<?php

use Illuminate\Database\Seeder;

use App\GroupActions;

class GroupActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userActions = [
            [
                'key' => 'ban',
                'action' => 'BAN USER FROM GROUP'
            ],
            [
                'key' => 'unban',
                'action' => 'UNBAN USER FROM GROUP'
            ],
            [
                'key' => 'add-admin',
                'action' => 'ADD TO ADMIN'

            ],
            [
                'key' => 'remove-admin',
                'action' => 'REMOVE FROM ADMIN'
            ]
        ];
        foreach ($userActions as $entity) {
            $this->createGroupActions($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createGroupActions($data)
    {
        $userAction = new GroupActions();
        $userAction->key = $data['key'];
        $userAction->action = $data['action'];
        $userAction->save();
    }
}