<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_user',
        'order_date',
        'pickedup_at',
        'total_amount',
        'order_status',
        'tracking_number',
        'shipping_notes',
        'rejection_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_order', 'id_order');
    }
}
