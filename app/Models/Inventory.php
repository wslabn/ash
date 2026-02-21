<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    
    protected $fillable = [
        'user_id', 'product_id', 'variant_id', 'quantity',
        'cost_per_unit', 'tax_paid_per_unit', 'retail_price',
        'low_stock_threshold', 'expiration_date', 'batch_number', 'purchased_at'
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'purchased_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
