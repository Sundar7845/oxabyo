<?php

use Illuminate\Database\Seeder;
use App\EventType;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = [
            [
                'name'             => 'Playoff',
                'description'      => 'Playoff',
                'status'           => 1
            ],
            [
                'name'             => 'Challenge Round',
                'description'      => 'Challenge Round',
                'status'           => 1
            ],
            [
                'name'             => 'Single Player',
                'description'      => 'Single Player',
                'status'           => 1
            ],
            [
                'name'             => 'One shot',
                'description'      => 'One shot',
                'status'           => 1
            ]
        ];

        foreach ($eventTypes as $entity) {
            $this->createEventType($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createEventType($data)
    {
        $event = new EventType();
        $event->name = $data['name'];
        $event->description = $data['description'];
        $event->status = $data['status'];
        $event->save();
    }
}
