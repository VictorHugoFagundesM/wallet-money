<?php

namespace App\Http\Requests;

use App\Models\Refund;
use App\Models\Transaction;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreRefundRequest extends FormRequest
{
/**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "reason" => ["required", "text", "max:300"],
            "transaction_id" => ["required", "integer", "exists:transactions,id"]
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $user = Auth::user();

            if (isset($this->transaction_id) && $this->transaction_id) {
                $transaction = Transaction::find($this->transaction_id);
                $refund = Refund::where(["reciever_id" => $user->id, "transaction_id" => $transaction->id])->count();

                if (!($transaction && $transaction->is_success && $transaction->payer->id == $user->id)) {
                    $validator->errors()->add('reason', 'Não é possível solicitar o estorno desta transação!');
                }

                if ($refund) {
                    $validator->errors()->add('reason', 'já existe uma solicitação de estorno para esta transação!');
                }

            }

        });
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator);
    }
}
