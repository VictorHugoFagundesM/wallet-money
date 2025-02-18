<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function payerTransactions() {
        return $this->hasMany(Transaction::class, 'payer_id');
    }

    public function receiverTransactions() {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }

    public function transactions() {
        $test = Transaction::join('users as payer', 'transactions.payer_id', '=', 'payer.id')
        ->join('users as receiver', 'transactions.receiver_id', '=', 'receiver.id')
        ->where(function ($query) {
            $query->where('transactions.payer_id', $this->id)
            ->orWhere(function ($query) {
                $query->where('transactions.is_success', true)
                ->where('transactions.receiver_id', $this->id);
            });
        })
        ->select(
            'transactions.*',
            'payer.id as payer_id',
            'payer.name as payer_name',
            'receiver.id as receiver_id',
            'receiver.name as receiver_name'
        )
        ->orderBy("transactions.created_at", "desc");

        return $test->get();
    }

    public function payerRefunds() {
        return $this->hasMany(Refund::class, 'payer_id');
    }

    public function bankSlips() {
        return $this->hasMany(BankSlip::class, 'created_by');
    }

    public function receiverRefunds() {
        return $this->hasMany(Refund::class, 'receiver_id');
    }

}
