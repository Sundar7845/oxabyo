<?php

use Illuminate\Database\Seeder;

/** Models */

use App\EventPointMapping;

class AddEventPointMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entities =  [
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "1st_position",
                "value" => "1st Position",
                "points" => 100,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "2nd_position",
                "value" => "2nd Position",
                "points" => 60,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "3rd_position",
                "value" => "3rd Position",
                "points" => 40,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "4th_position",
                "value" => "4th Position",
                "points" => 30,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "5th_position",
                "value" => "5th Position",
                "points" => 25,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "6th_position",
                "value" => "6th Position",
                "points" => 20,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "7th_position",
                "value" => "7th Position",
                "points" => 15,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "8th_position",
                "value" => "8th Position",
                "points" => 10,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 1,
                "key" => "9th_to_16th_position",
                "value" => "9th - 16th position",
                "points" => 5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 2,
                "key" => "event_participation",
                "value" => "Event participation (played)",
                "points" => 5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 2,
                "key" => "victory_1_match",
                "value" => "Victory 1 match",
                "points" => 10,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 2,
                "key" => "win_vs_higher_level_player",
                "value" => "Win VS Higher level player/team/Champion",
                "points" => 25,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 2,
                "key" => "win_vs_same_level_player",
                "value" => "Win VS same level player/team",
                "points" => 10,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 2,
                "key" => "win_vs_lower_level_player",
                "value" => "Win VS lower level player/team",
                "points" => 5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 2,
                "key" => "win_event_without_loss",
                "value" => "Win the event without loss",
                "points" => 25,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 3,
                "key" => "no_victories",
                "value" => "No victories",
                "points" => -10,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 3,
                "key" => "loss_vs_higher_level_player",
                "value" => "Lose VS Higher level player/team/Champion",
                "points" => 0,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 3,
                "key" => "loss_vs_same_level_player",
                "value" => "Lose VS same level player/team",
                "points" => -5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 3,
                "key" => "loss_vs_lower_level_player",
                "value" => "Lose VS Lower level player/team",
                "points" => -10,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 1,
                "category_id" => 3,
                "key" => "do_not_participate",
                "value" => "Do not participate (after joined the event)",
                "points" => -15,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "event_creation",
                "value" => "Event creation",
                "points" => 100,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "event_streaming",
                "value" => "Event streaming",
                "points" => 50,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "watch_streaming",
                "value" => "Watch streaming",
                "points" => 15,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "give_a_like",
                "value" => "Give a LIKE",
                "points" => 1,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "create_comment",
                "value" => "Create Comment",
                "points" => 5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "daily_login",
                "value" => "Daily Login",
                "points" => 1,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "connect_with_an_user",
                "value" => "Connect with an User",
                "points" => 3,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "complete_profile",
                "value" => "Complete Profile",
                "points" => 50,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 2,
                "key" => "received_likes",
                "value" => "Received Likes",
                "points" => 1,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 3,
                "key" => "not_logged_for_a_week",
                "value" => "Not logged for a week",
                "points" => -5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 3,
                "key" => "not_event_watched",
                "value" => "Not Event watched",
                "points" => -30,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 2,
                "category_id" => 3,
                "key" => "no_likes_for_a_week",
                "value" => "No likes for a week",
                "points" => -5,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 3,
                "category_id" => 2,
                "key" => "pay_event_creation",
                "value" => "Pay Event Creation",
                "points" => 100,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 3,
                "category_id" => 2,
                "key" => "win_a_prize",
                "value" => "Win a Prize",
                "points" => 125,
                "is_active" => 1
            ],
            [
                "reward_type_id" => 3,
                "category_id" => 2,
                "key" => "pay_event_participations",
                "value" => "Pay Event participations",
                "points" => 10,
                "is_active" => 1
            ]
        ];

        foreach ($entities as $entity) {
            $this->create($entity);
        }
    }

    /**
     * Create EventPointMapping entity.
     *
     * @param $data
     * @return EventPointMapping
     */
    private function create($data)
    {
        $userAction = new EventPointMapping();
        $userAction->reward_type_id = $data['reward_type_id'];
        $userAction->category_id = $data['category_id'];
        $userAction->key = $data['key'];
        $userAction->value = $data['value'];
        $userAction->points = $data['points'];
        $userAction->is_active = 1;
        $userAction->save();
    }
}
