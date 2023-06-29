<?php

use Illuminate\Database\Seeder;

use App\TeamAction;

class TeamActionSeeder extends Seeder
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
                'action' => 'BAN USER FROM TEAM'
            ],
            [
                'key' => 'unban',
                'action' => 'UNBAN USER FROM TEAM'
            ],
            [
                'key' => 'make-admin',
                'action' => 'ADD TO ADMIN'

            ],
            [
                'key' => 'remove-admin',
                'action' => 'REMOVE FROM ADMIN'
            ]
        ];
        foreach ($userActions as $entity) {
            $this->createTeamAction($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createTeamAction($data)
    {
        $userAction = new TeamAction();
        $userAction->key = $data['key'];
        $userAction->action = $data['action'];
        $userAction->save();
    }
}
