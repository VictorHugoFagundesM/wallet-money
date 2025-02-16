<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'type_id',
        'payer_id',
        'receiver_id',
        'is_success',
        'amount',
    ];

    public function type() {
        return $this->belongsTo(TransactionType::class, 'type_id');
    }

    public function payer() {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function refunds() {
        return $this->hasMany(Refund::class, 'transaction_id');
    }

}
