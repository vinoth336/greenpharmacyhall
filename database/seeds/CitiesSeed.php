<?php

use Illuminate\Database\Seeder;

class CitiesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Cities::class,25)->create(['state_id'=>1]); 
    }
}
