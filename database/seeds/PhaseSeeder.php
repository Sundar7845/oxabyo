<?php

use Illuminate\Database\Seeder;

/** Models */
use App\Phase;

class PhaseSeeder extends Seeder
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
                'key' => '32-players',
                'action' => '32 Players',
                'value' => '32',
                'round' => '5'
            ],
            [
                'key' => '16-players',
                'action' => '16 Players',
                'value' => '16',
                'round' => '4'
            ],
            [
                'key' => '8-players',
                'action' => '8 Players',
                'value' => '8',
                'round' => '3'
            ],
            [
                'key' => '4-players',
                'action' => '4 Players',
                'value' => '4',
                'round' => '2'
            ],
            [
                'key' => '2-players',
                'action' => '2 Players',
                'value' => '2',
                'round' => '1'
            ],
            [
                'key' => 'super-final',
                'action' => 'Super Final',
                'value' => '2',
                'round' => '0'
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
     * @return Phase
     */
    private function createAction($data)
    {
        $userAction = new Phase();
        $userAction->key = $data['key'];
        $userAction->action = $data['action'];
        $userAction->value = $data['value'];
        $userAction->round = $data['round'];
        $userAction->save();
    }
}
