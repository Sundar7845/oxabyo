<?php

use Illuminate\Database\Seeder;

/** Models */
use App\RewardType;

class AddRewardTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entities = [
            [
                'key' => 'performance',
                'full_name' => 'Performance',
                'short_name' => 'O'
            ],
            [
                'key' => 'social',
                'full_name' => 'Social',
                'short_name' => 'Y'
            ],
            [
                'key' => 'monetization',
                'full_name' => 'Monetization',
                'short_name' => 'A'
            ]
        ];
        foreach ($entities as $entity) {
            $this->create($entity);
        }
    }

    /**
     * Create RewardType entity.
     *
     * @param $data
     * @return RewardType
     */
    private function create($data)
    {
        $userAction = new RewardType();
        $userAction->key = $data['key'];
        $userAction->full_name = $data['full_name'];
        $userAction->short_name = $data['short_name'];
        $userAction->save();
    }
}
