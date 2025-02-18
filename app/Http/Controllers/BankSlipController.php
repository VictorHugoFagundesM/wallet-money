<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\BankSlip;
use App\Models\User;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\CheckBankSlipRequest;
use App\Http\Requests\StoreBankSlipRequest;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BankSlipController extends Controller
{

    /**
     * Redireciona à página de index de boletos
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $bankSlips = BankSlip::search($request->search, $user->id)->orderBy("created_at", "desc")->get();

        return view('bank-slips.index', [
            'user' => $user,
            'bankSlips' => $bankSlips,
        ]);
    }

    /**
     * Redireciona à página de informações do boleto
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function info(int $id): View|RedirectResponse
    {
        $bankSlip = BankSlip::find($id);

        if ($bankSlip) {
            return view('bank-slips.info', [
                'user' => Auth::user(),
                'bankSlip' => $bankSlip,
            ]);

        } else {
            return back()->withErrors('Transação não encontrada!');
        }
    }

    /**
     * Redireciona à página de criação do boleto
     *
     * @param BankSlip $bankSlip
     * @return View
     */
    public function create(BankSlip $bankSlip): View
    {

        return view('bank-slips.create', [
            'user' => Auth::user(),
            'bankSlip' => $bankSlip,
        ]);
    }

    /**
     * Redireciona à página de pagamento de Boletos
     *
     * @return View
     */
    public function payment(): View
    {
        $user = Auth::user();

        return view('bank-slips.payment', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Redireiona à confirmação de pagamento do boleto
     *
     * @param CheckBankSlipRequest $request)
     * @return RedirectResponse
     */
    public function paymentCheck(CheckBankSlipRequest $request): RedirectResponse
    {
        $bankSlip = BankSLip::where("code", $request->code)->first();
        return redirect()->route('bank-slip.payment.confirmation', ["id" => $bankSlip->id]);
    }

    /**
     * Redireiona à confirmação de pagamento do boleto
     *
     * @param CheckBankSlipRequest $request)
     * @return RedirectResponse|View
     */
    public function paymentConfirmation(int $id): RedirectResponse|View
    {
        $bankSlip = BankSlip::find($id);

        if ($bankSlip) {
            return view('bank-slips.payment-confirmation', [
                'user' => Auth::user(),
                'bankSlip' => $bankSlip,
            ]);

        } else {
            return back()->withErrors('Boleto inválido!');
        }
    }

    /**
     * Cria uma nova transação relacionada ao Boleto
     *
     * @param StoreBankSlipRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBankSlipRequest $request): RedirectResponse
    {

        try {
            $user = Auth::user();

            $bankSlip = BankSlip::create([
                'name' => $request->name,
                'code' => str_pad(mt_rand(1, 999999999999999), 33, '0', STR_PAD_LEFT),
                'amount' => $request->amount,
                'created_by' => $user->id,
            ]);

            return Redirect::route('bank-slip.info', ["id" =>  $bankSlip->id]);

        } catch (Exception $e) {
            Log::error("[BANK-SLIP-CONTROLLER][STORE] Erro ao criar boleto: ".$e->getMessage());
            return back()->withErrors('Ocorreu um problema ao criar o boleto, contate um admnistrador ou tente novamente mais tarde.');
        }
    }

}
