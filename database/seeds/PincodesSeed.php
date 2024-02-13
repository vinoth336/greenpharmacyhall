<?php

use Illuminate\Database\Seeder;

class PincodesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pincode::class,24)->create();
    }
}
