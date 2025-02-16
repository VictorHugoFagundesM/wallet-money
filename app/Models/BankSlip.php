<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSlip extends Model
{
    /** @use HasFactory<\Database\Factories\BankSlipFactory> */
    use HasFactory;

    public function type() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
