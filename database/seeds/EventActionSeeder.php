<?php

use Illuminate\Database\Seeder;

/** Models */
use App\EventAction;

class EventActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            [
                'key' => 'ban',
                'action' => 'BAN USER FROM EVENT'
            ],
            [
                'key' => 'unban',
                'action' => 'UNBAN USER FROM EVENT'
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
        foreach ($actions as $entity) {
            $this->createAction($entity);
        }
    }

    /**
     * Create EventAction entity.
     *
     * @param $data
     * @return EventAction
     */
    private function createAction($data)
    {
        $userAction = new EventAction();
        $userAction->key = $data['key'];
        $userAction->action = $data['action'];
        $userAction->save();
    }
}
