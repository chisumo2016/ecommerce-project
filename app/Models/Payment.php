<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'type',
        'amount',
        'created_by',
        'updated_by',
        'session_id'
    ];

    public  function  order():HasOne
    {
        return  $this->hasOne(
             related: Order::class,
             foreignKey: 'id',
             localKey: 'order_id'
        );
    }
}
