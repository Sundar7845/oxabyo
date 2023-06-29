<?php

use Illuminate\Database\Seeder;
use App\PlayerType;

class PlayerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playerTypes = [
            [
                'name'             => 'Players',
                'description'      => 'Players',
                'status'           => 1
            ],
            [
                'name'             => 'Team',
                'description'      => 'Team',
                'status'           => 1
            ]
        ];

        foreach ($playerTypes as $entity) {
            $this->createPlayerType($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createPlayerType($data)
    {
        $playerType = new PlayerType();
        $playerType->name = $data['name'];
        $playerType->description = $data['description'];
        $playerType->status = $data['status'];
        $playerType->save();
    }
}
