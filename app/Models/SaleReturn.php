<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $table = 'returns';
    
    protected $fillable = [
        'sale_id', 'user_id', 'customer_id', 'return_number', 
        'total_amount', 'restore_inventory', 'reason', 'status', 'returned_at'
    ];

    protected $casts = [
        'returned_at' => 'datetime',
        'restore_inventory' => 'boolean',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

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
        return $this->hasMany(ReturnItem::class, 'return_id');
    }
}
