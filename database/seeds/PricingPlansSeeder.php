<?php

use Illuminate\Database\Seeder;
use App\PricingPlan;

class PricingPlansSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userActions = [
            [ 
                'key' => 'noob',
                'plan_name' => 'Noob',                
                'month_price' => '0',
                'year_price' => '0',
                'is_active' => '1'
            ],
            [
                'key' => 'geek',
                'plan_name' => 'Geek',                
                'month_price' => '1.99',
                'year_price' => '11.94',
                'is_active' => '1'
            ],
            [
                'key' => 'pro',
                'plan_name' => 'Pro',                
                'month_price' => '3.99',
                'year_price' => '23.94',
                'is_active' => '1'
            ],
        ];

        foreach ($userActions as $entity) {
            $this->createUserActions($entity);
        }
    }

    /**
     * Create user for local entity.
     *
     * @param $data
     * @return User
     */
    private function createUserActions($data)
    {
        $userAction = new PricingPlan();
        $userAction->key = $data['key'];
        $userAction->plan_name = $data['plan_name'];
        $userAction->month_price = $data['month_price'];
        $userAction->year_price = $data['year_price'];
        $userAction->is_active = $data['is_active'];
        $userAction->save();
    }
}
