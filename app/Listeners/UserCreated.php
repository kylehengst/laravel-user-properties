<?php

namespace App\Listeners;

use App\Property;
use App\Events\UserWasCreated;
use Faker\Generator;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreated
{

    protected $faker;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        // $event
        $event->user;

        // cyberduck location
        $lat = 51.6448554;
        $lng = -0.3004618;

        // add 10 random properties
        for($i=0; $i<10; $i++){
            Property::create([
                'name' => $this->faker->sentence,
                'user_id' => $event->user->id,
                'latitude' => $this->faker->latitude(51,52),
                'longitude' => $this->faker->longitude(-.5,.5),
            ]);
        }
    }
}
