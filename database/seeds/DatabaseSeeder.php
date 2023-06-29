<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EventTypeSeeder::class);
        $this->call(PlayerTypeSeeder::class);

        $this->call(TeamActionSeeder::class);
        $this->call(UserActionSeeder::class);

        $this->call(EventActionSeeder::class);
        $this->call(PhaseSeeder::class);
        $this->call(VoteSeeder::class);

        $this->call(GroupActionSeeder::class);
        $this->call(AddRewardTypesSeeder::class);
        $this->call(AddPointCategorySeeder::class);        
        $this->call(AddEventPointMappingSeeder::class);

        /**
         * Subscription and permissions seeder
         */
	    $this->call(PricingPlansSeeder::class);
	    $this->call(PermissionSeeder::class);
	    $this->call(SubscriptionPermissionsSeeder::class);

        
    }
}
