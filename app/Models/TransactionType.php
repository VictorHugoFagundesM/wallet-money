<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{

    protected $fillable = [
        'name',
    ];

    public function type() {
        return $this->hasMany(Transaction::class, 'type_id');
    }

}
