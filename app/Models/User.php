<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\EmailVerificationNotification;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    # email verification notification
    public function sendVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    # guarded
    protected $guarded = [
        ''
    ];

    # hidden for serializations
    protected $hidden = [
        'password',
        'remember_token',
    ];

    # should be casted
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # user shop
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    # role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    # address 
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    # order Group 
    public function orderGroups()
    {
        return $this->hasMany(OrderGroup::class);
    }
    # orders 
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    # carts
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    # wishlist
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    # rewards 
    public function rewards()
    {
        return $this->hasMany(RewardPoint::class);
    }

    # wallets 
    public function wallets()
    {
        return $this->hasMany(WalletHistory::class);
    }

    # refunds 
    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
