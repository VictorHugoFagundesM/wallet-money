<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreTransactionRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => (int) preg_replace('/\D/', '', $this->amount),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "account_number" => ["nullable", "required_without:code", "exists:users,account_number"],
            "code" => ["nullable", "required_without:account_number", "exists:users,account_number"],
            "amount" => ["required", "integer"],
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $user = Auth::user();

            if ($this->amount <= 0) {
                $validator->errors()->add('amount', 'O valor da transferência deve ser maior do que 0.');
            }

            if ($this->amount > $user->balance) {
                $validator->errors()->add('amount', 'Você não possui saldo suficiente para realizar esta transação.');
            }

            if (isset($this->account_number) && $user->account_number == $this->account_number) {
                $validator->errors()->add('account_number', 'Não é possível realizar uma transação para a mesma conta.');
            }


        });
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator);
    }

}
