<?php

namespace App\Http\Controllers;

use App\Enums\RefundStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\StoreRefundRequest;
use App\Models\BankSlip;
use App\Models\Refund;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
class RefundController extends Controller
{
    /**
     * Redireciona à tela de criação
     *
     * @return View
     */
    public function create(int $id): View
    {
        $transaction = Transaction::find($id);
        $user = Auth::user();

        if ($transaction && $transaction->is_success && $transaction->payer->id == $user->id) {
            return view('refunds.create', [
                'user' => $user,
                'transaction' => $transaction,
            ]);

        } else {
            return back()->withErrors('Não é possível solicitar o estorno desta transação!');
        }
    }

    public function success() {
        return view('refunds.success');
    }

    public function pending() {
        return view('refunds.pending');
    }


    /**
     * Salva a transação
     *
     * @param StoreRefundRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRefundRequest $request): RedirectResponse
    {

        try {
            $user = Auth::user();
            $transaction = Transaction::find($request->transaction_id);
            $status = RefundStatusEnum::REFUNDED;

            // Obtém a quantidade de estornos solicitados pelo usuário
            $refund = Refund::where("reciever_id", $user->id)
            ->whereDate("created_at", Carbon::today()->toDateString())
            ->count();

            if (count($refund) > 1) {
                $status = RefundStatusEnum::PENDING;
            }

            DB::beginTransaction();

            $refund = Refund::create([
                'transaction_id' => $transaction->id,
                'payer_id' => $transaction->receiver_id,
                'receiver_id' => $transaction->payer_id,
                'bank_slip_id' => $request->reason,
                'status_id' => $status
            ]);

            if ($status == RefundStatusEnum::REFUNDED) {

                Transaction::create([
                    'type_id' => $transaction->type_id,
                    'payer_id' => $refund->payer_id,
                    'receiver_id' => $refund->receiver_id,
                    'amount' => $transaction->amount,
                    'bank_slip_code' => $transaction->bank_slip_code,
                    'bank_slip_id' => $transaction->bank_slip_id,
                    'is_success' => true
                ]);

                DB::commit();

                return view('refunds.success');
            }

            DB::commit();
            return view('refunds.pending');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error("[TRANSACTION-CONTROLLER][STORE] Erro ao criar transação: ".json_encode($request->all()). ". Erro:".$e->getMessage());
            return back()->withErrors('Ocorreu um problema ao solicitar o estorno, contate um admnistrador ou tente novamente mais tarde.');
        }
    }

}
