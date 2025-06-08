<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;
    protected $table = 'payments';
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'id_order',
        'method',
        'payment_category',
        'payment_status',
        'payment_date',
        'payment_document'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}
