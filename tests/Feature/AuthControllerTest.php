<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mvaliolahi\Auth\Models\User;
use Mvaliolahi\Auth\Models\VerificationToken;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function testLoginForm()
    {
        $this->get(route('auth.login'))->assertSuccessful();
    }

    public function testSendToken()
    {
        $mobile = '09111111111';

        // 1. Send token to user mobile.
        $this->post(route('auth.send.token'), [
            'mobile' => $mobile
        ])->assertRedirect(route('auth.verify.form', ['mobile' => $mobile ]));
        
        $user = User::first();

        // 3. Assert users registered + create verification token for him / her.
        $this->assertEquals($mobile, $user->mobile);
        $this->assertCount(1, VerificationToken::all());
    }

    public function testVerify()
    {
        $mobile = '09111111111';

        // 1. Send Token
        $this->post(route('auth.send.token'), [
            'mobile' => $mobile
        ])->assertRedirect(route('auth.verify.form', ['mobile' => $mobile ]));

        // 2. verify token
        $token = VerificationToken::first();

        $this->post(route('auth.verify'), [
            'token' =>  $token->token,
            'mobile' => $mobile
        ]);

        // 3. assert auth + token mark as used.
        $this->assertTrue((bool)$token->fresh()->used);
        $this->assertTrue(Auth::check());
    }
}
