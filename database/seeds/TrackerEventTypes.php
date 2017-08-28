<?php

use Illuminate\Database\Seeder;

class TrackerEventTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tracker_event_types')->insert([
            'name' => 'pageLoad'
        ]);

        DB::table('tracker_event_types')->insert([
            'name' => 'pageDebounce'
        ]);

        DB::table('tracker_event_types')->insert([
            'name' => 'checkout'
        ]);

        DB::table('tracker_event_types')->insert([
            'name' => 'addToCart'
        ]);
    }
}
