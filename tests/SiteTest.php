<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SiteTest extends TestCase
{

//    use DatabaseMigrations;
    use DatabaseTransactions;

//    public function setUp()
//    {
//        parent::setUp();
//    }

    public function testUserCreateDoesFail()
    {
//        $this->json('POST', '/api/users', ['name' => 'Kyle'])
//            ->seeJson([
//                ['The email field is required.']
//            ]);

        $response = $this->call('POST', '/api/users', ['name' => 'Kyle']);

        $this->assertEquals(400, $response->status());
    }

    public function testUserCreateDoesSucceed()
    {
        $user = factory(App\User::class)->make();

        $response = $this->call('POST', '/api/users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);

        $this->assertEquals(201, $response->status());

//        $this->seeInDatabase('users', ['email' => $user->email]);

        // check user exists
        $user = App\User::where('email', $user->email)->first();
        $this->assertNotNull($user);

        // check if user properties exists
        $count = App\Property::where(['user_id' => $user->id])->count();
        $this->assertGreaterThan(0, $count);

    }

    public function testGetProperties()
    {
        $response = $this->call('GET', '/api/properties');
        $this->assertEquals(200, $response->status());
    }

    public function testGetPropertiesWithUserId()
    {
        $user = factory(App\User::class)->create();

        $response = $this->call('GET', '/api/properties?user_id='.$user->id);

        $this->assertEquals(200, $response->status());

        $data = json_decode($response->getContent(), true);

        $this->assertGreaterThan(0, count($data));
    }

    public function testUpdateProperty()
    {
        $user = factory(App\User::class)->create();

        $property = App\Property::where('user_id',$user->id)->first();

        $this->assertNotNull($property);

        $faker = \Faker\Factory::create();

        $response = $this->call('PUT', '/api/properties/'.$property->id.'?api_token='.$user->api_token,[
            'name' => $faker->name,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
        ]);

        $this->assertEquals(200, $response->status());
    }

}
