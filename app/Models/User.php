<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_USER = 0;
    public const ROLE_ADMIN = 1;
    public const ROLE_SHOP_MANAGER = 2;
    public const ROLE_BLOG_MANAGER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isShopManager(): bool
    {
        return $this->role === self::ROLE_SHOP_MANAGER;
    }

    public function isBlogManager(): bool
    {
        return $this->role === self::ROLE_BLOG_MANAGER;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

//    public static function rolesList(): array
//    {
//        return [
//            User::ROLE_USER => 'User',
//            User::ROLE_SHOP_MANAGER => 'ShopManager',
//            User::ROLE_BLOG_MANAGER => 'BlogManager',
//            User::ROLE_ADMIN => 'Admin'
//        ];
//    }

}
