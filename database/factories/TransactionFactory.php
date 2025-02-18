<?php

namespace Database\Factories;

use App\Enums\TransactionTypeEnum;
use App\Models\BankSlip;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $receiver = User::inRandomOrder()->first();
        $payer = User::inRandomOrder()->whereNot("id", $receiver->id)->first();
        $typeId = TransactionType::inRandomOrder()->first()->id;
        $bankSlipCode = null;
        $bankSlipId = null;
        $isSuccess = true;
        $amount = 0;

        // Caso seja uma operação com boleto, salva seu código e o seu valor
        if ($typeId == TransactionTypeEnum::BANK_SLIP) {
            $bankSlip = BankSlip::inRandomOrder()->first();
            $bankSlipCode = $bankSlip->code;
            $amount = $bankSlip->amount;
            $bankSlipId = $bankSlip->id;

        } else {
            $amount = fake()->numberBetween(1, 99999);
        }

        if ($payer->balance - $amount < 0) {
            $isSuccess = false;
        }

        // Caso a transação seja marcada como bem-sucessida modifica os saldos do recebedor e do pagador
        if ($isSuccess) {
            $receiver->balance += $amount;
            $receiver->save();

            $payer->balance -= $amount;
            $payer->save();
        }

        return [
            'type_id' => $typeId,
            'payer_id' => $payer ? $payer->id : null,
            'receiver_id' => $receiver->id,
            'bank_slip_code' => $bankSlipCode,
            'bank_slip_id' => $bankSlipId,
            'amount' => $amount,
            'is_success' => $isSuccess
        ];
    }
}
