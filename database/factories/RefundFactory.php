<?php

namespace Database\Factories;

use App\Enums\RefundStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\RefundStatus;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Refund>
 */
class RefundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transaction = Transaction::where("is_success", true)->inRandomOrder()->first();
        $payer = User::find($transaction->receiver_id);
        $receiver = User::find($transaction->payer_id);
        $status = RefundStatus::inRandomOrder()->first();

        if ($status->id == RefundStatusEnum::REFUNDED) {
            $receiver->balance += $transaction->amount;
            $receiver->save();

            $payer->balance -= $transaction->amount;
            $payer->save();

            $transaction->is_success = false;

            Transaction::create([
                "type_id" => TransactionTypeEnum::REFUND,
                "payer_id" => $payer->id,
                "receiver_id" => $receiver->id,
                "is_success" => true,
                "amount" => $transaction->amount,
            ]);
        }

        return [
            'transaction_id' => $transaction->id,
            'payer_id' => $payer->id,
            'receiver_id' => $receiver->id,
            'status_id' => $status->id,
            'reason' => fake()->text(200)
        ];
    }
}
