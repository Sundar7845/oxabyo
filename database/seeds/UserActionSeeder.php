<?php

use Illuminate\Database\Seeder;

/** Models */
use App\UserAction;

class UserActionSeeder extends Seeder
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
                'key' => 'connect',
                'action' => 'Connect'
            ],
            [
                'key' => 'unconnect',
                'action' => 'Unconnect'
            ],
            [
                'key' => 'like',
                'action' => 'Like'

            ],
            [
                'key' => 'unlike',
                'action' => 'Unlike'
            ],
            [
                'key' => 'block',
                'action' => 'Block'
            ],
            [
                'key' => 'unblock',
                'action' => 'UnBlock'
            ],
            [
                'key' => 'send-message',
                'action' => 'Send Message'
            ],
            [
                'key' => 'report-abuse',
                'action' => 'Report Abuse'
            ]
        ];
        foreach ($userActions as $entity) {
            $this->createUserAction($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createUserAction($data)
    {
        $userAction = new UserAction();
        $userAction->key = $data['key'];
        $userAction->action = $data['action'];
        $userAction->save();
    }
}
