<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSlip extends Model
{
    /** @use HasFactory<\Database\Factories\BankSlipFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'created_by',
        'amount',
    ];

    public function type() {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Realiza busca das notícias
     *
     * @param object $query
     * @param string $search
     * @return void
     */
    public function scopeSearch($query, string $search = null, int $userId) {
        $query->selectRaw('bs.*, (
            select true from transactions as t where t.bank_slip_id = bs.id and t.is_success = true limit 1
        ) as is_payed')
        ->from('bank_slips as bs')
        ->where("bs.created_by", $userId);

        if ($search) {
            $query->whereRaw("bs.name ilike '%".trim($search)."%'");
        }

        return $query;
    }

}
