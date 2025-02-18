<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    /** @use HasFactory<\Database\Factories\RefundFactory> */
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payer_id',
        'receiver_id',
        'status_id',
        'reason',
    ];


    public function payer() {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function transaction() {
        return $this->belongsTo(User::class, 'transaction_id');
    }

    public function status() {
        return $this->belongsTo(RefundStatus::class, 'status_id');
    }

}
