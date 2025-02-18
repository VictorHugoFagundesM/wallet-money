<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypeEnum;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\BankSlip;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{

    /**
     * Página de detalhes de pagamentos
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function info(int $id): View|RedirectResponse
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            return view('transactions.info', [
                'user' => Auth::user(),
                'transaction' => $transaction,
            ]);

        } else {
            return back()->withErrors('Transação não encontrada!');
        }
    }

    /**
     * Redireciona à tela de criação
     *
     * @return View
     */
    public function create(): View
    {
        $user = Auth::user();
        return view("transactions.create", ["user" => $user]);
    }

    /**
     * Salva a transação
     *
     * @param StoreTransactionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTransactionRequest $request): RedirectResponse
    {

        try {
            $payer = Auth::user();
            $typeId = null;
            $bankSlipCode = null;
            $bankSlipId = null;

            // Caso seja uma transferência
            if (isset($request->account_number)) {
                $receiver = User::where(["account_number" => $request->account_number])->first();
                $typeId = TransactionTypeEnum::TRANSFER;

            // Caso seja um depósito por boleto
            } else {
                $bankSlip = BankSlip::where(["code" => $request->code])->first();
                $receiver = User::where(["id" => $bankSlip->created_by])->first();
                $typeId = TransactionTypeEnum::BANK_SLIP;
                $bankSlipCode = $request->code;
                $bankSlipId = $bankSlip->id;
            }

            DB::beginTransaction();

            $transaction = Transaction::create([
                'type_id' => $typeId,
                'payer_id' => $payer->id,
                'receiver_id' => $receiver->id,
                'amount' => $request->amount,
                'bank_slip_code' => $bankSlipCode,
                'bank_slip_id' => $bankSlipId,
                'is_success' => true
            ]);

            $payer->balance -= $request->amount;
            $receiver->balance += $request->amount;

            $payer->save();
            $receiver->save();

            DB::commit();

            return Redirect::route('transaction.info', ["id" =>  $transaction->id]);

        } catch (Exception $e) {
            DB::rollBack();

            $transaction = Transaction::create([
                'type_id' => $typeId,
                'payer_id' => $payer->id ?? null,
                'receiver_id' => $receiver->id  ?? null,
                'amount' => $request->amount ?? 0,
                'bankSlipCode' => $bankSlipCode,
                'is_success' => false
            ]);

            Log::error("[TRANSACTION-CONTROLLER][STORE] Erro ao criar transação: ".json_encode($request->all()). ". Erro:".$e->getMessage());
            return back()->withErrors('Ocorreu um problema ao completar a transação, contate um admnistrador ou tente novamente mais tarde.');
        }
    }

}
