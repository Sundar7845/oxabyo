<?php

use Illuminate\Database\Seeder;

use App\Vote;

class VoteSeeder extends Seeder
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
                'key' => 'terrible',
                'name' => 'TERRIBLE',
                'tag' => '1'
            ],
            [
                'key' => 'bad',
                'name' => 'BAD',
                'tag' => '1'
            ],
            [
                'key' => 'indifferent',
                'name' => 'INDIFFERENT',
                'tag' => '1'
            ],
            [
                'key' => 'good',
                'name' => 'GOOD',
                'tag' => '1'
            ],
            [
                'key' => 'excellent',
                'name' => 'EXCELLENT',
                'tag' => '1'
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
     * @return Vote
     */
    private function createAction($data)
    {
        $userAction = new Vote();
        $userAction->key = $data['key'];
        $userAction->name = $data['name'];
        $userAction->tag = $data['tag'];
        $userAction->save();
    }
}
