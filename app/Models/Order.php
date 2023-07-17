<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeIsPaid($query)
    {
        return $query->where('payment_status', paidPaymentStatus());
    }

    public function scopeIsUnpaid($query)
    {
        return $query->where('payment_status', unpaidPaymentStatus());
    }

    public function scopeIsPlaced($query)
    {
        return $query->where('delivery_status', orderPlacedStatus());
    }

    public function scopeIsPending($query)
    {
        return $query->where('delivery_status', orderPendingStatus());
    }

    public function scopeIsPlacedOrPending($query)
    {
        return $query->where('delivery_status', orderPlacedStatus())->orWhere('delivery_status', orderPendingStatus());
    }

    public function scopeIsProcessing($query)
    {
        return $query->where('delivery_status', orderProcessingStatus());
    }

    public function scopeIsPickedUp($query)
    {
        return $query->where('delivery_status', orderPickedUpStatus());
    }

    public function scopeIsOutForDelivery($query)
    {
        return $query->where('delivery_status', orderOutForDeliveryStatus());
    }

    public function scopeIsDelivered($query)
    {
        return $query->where('delivery_status', orderDeliveredStatus());
    }

    public function scopeIsCancelled($query)
    {
        return $query->where('delivery_status', orderCancelledStatus());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderGroup()
    {
        return $this->belongsTo(OrderGroup::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderUpdates()
    {
        return $this->hasMany(OrderUpdate::class)->latest();
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
