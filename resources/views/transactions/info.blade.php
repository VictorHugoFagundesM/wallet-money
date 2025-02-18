<x-app-layout>
    <div class="py-12">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-6">

            <div class="flex text-2xl mb-5">
                <a href="{{ url("/home") }}">
                    <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                </a>
                <x-transaction-description :transaction="$transaction" :user="Auth::user()" />
            </div>

            <div class="flex">
                @if ($transaction->is_success)
                    <i class="fa-solid text-4xl fa-arrow-trend-down text-red-500 ml-auto mr-auto mb-5 mt-5"></i>
                @else
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-4xl ml-auto mr-auto mb-5 mt-5"></i>
                @endif
            </div>

            <div  class="flex-1 flex flex-col">
                <span class="flex mb-4 text-end justify-center break-all">{{$transaction->is_success ? "" : "Falha na transação"}}</span>

                <span class="flex mb-2">
                    <span class="mr-2 text-sm font-light">Remetente:</span>
                    <span class="ml-auto text-end break-all">{{$transaction->payer->name}}</span>
                </span>

                <span class="flex mb-2">
                    <span class="mr-2 text-sm font-light">Beneficiário:</span>
                    <span class="ml-auto text-end break-all">{{$transaction->receiver->name}}</span>
                </span>

                @if ($transaction->bank_slip_code)

                    <span class="flex mb-2">
                        <span class="mr-2 text-sm font-light">Cód. Boleto:</span>
                        <span class="ml-auto text-end break-all">{{$transaction->bank_slip_code}}</span>
                    </span>

                @endif

                <span class="flex mb-2">
                    <span class="mr-2 text-sm font-light">Realizado em:</span>
                    <span class="ml-auto text-end break-all">{{ \Carbon\Carbon::parse($transaction->created_at)->locale('pt_BR')->isoFormat('dddd, D [de] MMMM [de] YYYY [às] HH:mm') }}</span>
                </span>

                <span class="flex mb-2  mt-4">
                    <span class="mr-2 text-sm font-light">Valor:</span>
                    <span class="ml-auto text-end break-all"> R$ {{str_replace('.', ',',(string)($transaction->amount / 100))}} </span>
                </span>

                @if ($transaction->is_success && $transaction->payer->id == $user->id)
                    <a
                        href="{{ route('refund.create', ["id" => $transaction->id]) }}"
                        class="ml-auto mr-auto mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                    >
                        Solicitar reembolso
                    </a>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>

