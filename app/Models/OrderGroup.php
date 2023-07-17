<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderGroup extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (OrderGroup::first() == null) {
                $model->order_code = getSetting('order_code_start') != null ? (int) getSetting('order_code_start') : 1;
            } else {
                $model->order_code = (int) OrderGroup::max('order_code') + 1;
            }
        });
    }

    # for single vendor hasOne todo::[update version] handle for multiple orders
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'shipping_address_id', 'id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'billing_address_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
