<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserRoleEnum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function role() {
        return $this->hasOne(Role::class);
    }

    public function company() {
        return $this->hasOne(Company::class);
    }

    protected $casts = [
        'role' => UserRoleEnum::class
    ];
}
