<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::create(['name'=>'Dhawala','email'=>'1234dhawala@gmail.com','password'=>'secret']);
        $this->assertEquals('Dhawala',$user->name);
        $this->assertEquals('1234dhawala@gmail.com',$user->email);
    }
}
