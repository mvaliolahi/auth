<?php

namespace Mvaliolahi\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Mvaliolahi\Auth\Models\User;

class VerificationToken extends Model
{
    protected $guarded = [
        'id'
    ];

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'mobile', 'mobile');
    }

    /**
     * @return bool
     */
    public function markUsed()
    {
        $this->used = true;
        return $this->save();
    }
}
