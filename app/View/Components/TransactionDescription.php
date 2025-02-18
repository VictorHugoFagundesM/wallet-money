<?php

namespace App\View\Components;

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\View\Component;

class TransactionDescription extends Component
{
    public $transaction;
    public $user;

    public function __construct(Transaction $transaction, User $user)
    {
        $this->transaction = $transaction;
        $this->user = $user;
    }

    public function getDescriptionText()
    {
        $transfer = TransactionTypeEnum::TRANSFER;
        $bankSlip = TransactionTypeEnum::BANK_SLIP;
        $refund = TransactionTypeEnum::REFUND;

        if ($this->transaction->is_success) {
            switch ($this->transaction->type_id) {
                case $transfer:
                    return $this->transaction->payer_id == $this->user->id ?
                        "Transferência Efetuada" : "Transferência Recebida";

                case $bankSlip:
                    return $this->transaction->payer_id == $this->user->id ?
                        "Pagamento Efetuado" : "Depósito Recebido";

                case $refund:
                    return $this->transaction->payer_id == $this->user->id ?
                        "Estorno do Pagamento" : "Pagamento Estornado";
            }
        }

        return "Erro na operação";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $description = $this->getDescriptionText();
        return view('components.transaction-description', ["description" => $description]);
    }
}
