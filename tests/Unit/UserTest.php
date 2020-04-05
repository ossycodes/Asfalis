<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    const TEST_ADMIN_EMAIL = "ossycodes@asfalis.com";

    /** @test */
    public function it_can_check_if_user_is_not_an_admin()
    {
        config(['asfalis.admins' => [
            self::TEST_ADMIN_EMAIL
        ]]);
        $nonAdminUser = factory(User::class)->create([
            "email" => "userwhoisnotanadmin@gmail.com"
        ]);
        $this->assertFalse($nonAdminUser->isAdmin());
    }

    /** @test */
    public function it_can_check_if_user_is_an_admin()
    {
        config(['asfalis.admins' => [
            self::TEST_ADMIN_EMAIL
        ]]);
        $nonAdminUser = factory(User::class)->create([
            "email" => self::TEST_ADMIN_EMAIL
        ]);
        $this->assertTrue($nonAdminUser->isAdmin());
    }

    /** @test */
    public function it_can_return_the_fullname()
    {
        $AdebowaleGracious = factory(User::class)->create([
            "first_name" => "Adebowale",
            "last_name" => "Gracious"
        ]);

        $this->assertEquals("Adebowale Gracious", $AdebowaleGracious->fullName);
    }

    /** @test */
    public function it_can_create_reset_token()
    {
        $newUser = factory(User::class)->create();

        $this->assertDatabaseMissing("reset_tokens", [
            "email" => $newUser->email
        ]);

        $newUser->createResetToken();

        $this->assertDatabaseHas("reset_tokens", [
            "email" => $newUser->email
        ]);
    }

    /** @test */
    public function it_can_check_if_user_has_a_reset_token()
    {
        $newUser = factory(User::class)->create();

        $newUser->createResetToken();

        $this->assertTrue($newUser->hasResetToken());
    }
}
