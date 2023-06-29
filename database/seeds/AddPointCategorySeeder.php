<?php

use Illuminate\Database\Seeder;

/** Models */
use App\PointCategory;

class AddPointCategorySeeder extends Seeder
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
                'key' => 'position_in_events',
                'value' => 'Position in the Event'
            ],
            [
                'key' => 'plus',
                'value' => 'Plus'
            ],
            [
                'key' => 'minus',
                'value' => 'Minus'
            ]
        ];

        foreach ($entities as $entity) {
            $this->create($entity);
        }
    }

    /**
     * Create PointCategory entity.
     *
     * @param $data
     * @return PointCategory
     */
    private function create($data)
    {
        $userAction = new PointCategory();
        $userAction->key = $data['key'];
        $userAction->value = $data['value'];
        $userAction->is_active = 1;
        $userAction->save();
    }
}
