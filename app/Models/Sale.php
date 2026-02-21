<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id', 'customer_id', 'sale_number', 'sale_type', 'subtotal',
        'discount_amount', 'discount_type', 'tax_amount', 'tax_rate',
        'shipping_amount', 'total_amount', 'payment_status', 'payment_method',
        'stripe_payment_intent_id', 'notes', 'sold_at'
    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
