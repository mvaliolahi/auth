<?php

namespace Mvaliolahi\Auth\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Mvaliolahi\Auth\Helpers\UniqueId\UniqueId;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    protected $guarded = [
        'id'
    ];

    /**
     * @return HasMany
     */
    public function verificationTokens()
    {
        return $this->hasMany(VerificationToken::class, 'mobile', 'mobile');
    }

    /**
     * @return int|null
     */
    public function verificationToken()
    {
        return !is_null($token = $this->verificationTokens()->latest()->first())  ? $token->token : null;
    }

    public function generateVerificationToken()
    {
        // If the mobile defined as test number, token must be 12345!
        $isTest = collect(config('auth_mobile.test_numbers'))->contains($this->mobile);

        // if user has an unused token and it's not expired , then return it
        $token = $this->verificationToken();
        $isExpired = Carbon::parse($token->created_at)->addSeconds(config('auth_mobile.token_expire'))->isPast();
        if ($token && !$token->used && !$isExpired) {
            return $token;
        }

        return $this->verificationTokens()->create([
            'token' => UniqueId::makeDigit(5, $isTest),
        ]);
    }
}
