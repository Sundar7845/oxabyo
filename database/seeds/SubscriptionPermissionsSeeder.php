<?php

use Illuminate\Database\Seeder;

use App\SubscriptionPermission;
use App\Permission;
use App\PricingPlan;

class SubscriptionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = PricingPlan::all()->keyBy('key');
        $permissions = Permission::all()->keyBy('key');
        $entities = [
            [
                'pricing_plan_id' => $plans['noob']['id'],
                'permission_id' => $permissions['event_participation']['id'],
                'value' => '2',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['noob']['id'],
                'permission_id' => $permissions['event_organization']['id'],
                'value' => '1',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['noob']['id'],
                'permission_id' => $permissions['team_create']['id'],
                'value' => '1',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['noob']['id'],
                'permission_id' => $permissions['team_join']['id'],
                'value' => '1',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['noob']['id'],
                'permission_id' => $permissions['group_create']['id'],
                'value' => '1',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['noob']['id'],
                'permission_id' => $permissions['group_join']['id'],
                'value' => '2',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['geek']['id'],
                'permission_id' => $permissions['event_participation']['id'],
                'value' => '10',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['geek']['id'],
                'permission_id' => $permissions['event_organization']['id'],
                'value' => '3',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['geek']['id'],
                'permission_id' => $permissions['team_create']['id'],
                'value' => '3',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['geek']['id'],
                'permission_id' => $permissions['team_join']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['geek']['id'],
                'permission_id' => $permissions['group_create']['id'],
                'value' => '3',
                'is_unlimited' => false,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['geek']['id'],
                'permission_id' => $permissions['group_join']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['pro']['id'],
                'permission_id' => $permissions['event_participation']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['pro']['id'],
                'permission_id' => $permissions['event_organization']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['pro']['id'],
                'permission_id' => $permissions['team_create']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['pro']['id'],
                'permission_id' => $permissions['team_join']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['pro']['id'],
                'permission_id' => $permissions['group_create']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ],
            [
                'pricing_plan_id' => $plans['pro']['id'],
                'permission_id' => $permissions['group_join']['id'],
                'value' => '0',
                'is_unlimited' => true,
                'is_allowed' => true
            ]
        ];

        foreach ($entities as $entity) {
            $this->create($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function create($data)
    {
        $entity = new SubscriptionPermission();
        $entity->pricing_plan_id = $data['pricing_plan_id'];
        $entity->permission_id = $data['permission_id'];
        $entity->value = $data['value'];
        $entity->is_unlimited = $data['is_unlimited'];
        $entity->is_allowed = $data['is_allowed'];
        $entity->save();
    }
}
