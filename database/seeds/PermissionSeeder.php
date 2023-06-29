<?php

use Illuminate\Database\Seeder;

use App\Permission;

class PermissionSeeder extends Seeder
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
                'key' => 'event_participation',
                'name' => 'Event Participation'
            ],
            [
                'key' => 'event_organization',
                'name' => 'Event Organization'
            ],
            [
                'key' => 'team_create',
                'name' => 'Team Creation'
            ],
            [
                'key' => 'team_join',
                'name' => 'Team Join'
            ],
            [
                'key' => 'group_create',
                'name' => 'Group Creation'
            ],
            [
                'key' => 'group_join',
                'name' => 'Group Join'
            ]
        ];

        foreach ($actions as $entity) {
            $this->create($entity);
        }
    }

    /**
     * @param $data
     * @return User
     */
    private function create($data)
    {
        $userAction = new Permission();
        $userAction->key = $data['key'];
        $userAction->name = $data['name'];
        $userAction->is_active = 1;
        $userAction->save();
    }
}
