<x-app-layout>

    <div class="py-12">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl">
                <div class="p-6 text-gray-900">

                    <div class="text-base text-lg font-medium mb-7">Olá, {{$user->name}}</div>

                    <div class="text-base text-lg font-light">Saldo:</div>

                    <div class="flex flex-row gap-4 items-center mt-4">
                        <div class="text-base font-extralight">R$</div>
                        <div class="text-2xl font-medium">{{str_replace('.', ',',(string)($user->balance / 100))}}</div>
                    </div>

                    <div class="flex flex-row gap-4 items-center pt-6 mt-6 border-t border-gray-300">

                        <a href="{{url('transaction')}}" class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center">
                            <i class="text-gray-600 text-xl fa-solid fa-arrow-trend-up"></i>
                            <span class="text-xs font-light">Transferência</span>
                        </a>

                        <a href="{{url('payment')}}" class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center">
                            <i class="text-gray-600 text-xl fa-solid fa-dollar-sign"></i>
                            <span class="text-xs font-light">Pagar</span>
                        </a>

                        <a href="{{url('bank-slip')}}" class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center">
                            <i class="text-gray-600 text-xl fa-regular fa-file-lines"></i>
                            <span class="text-xs font-light">Boletos</span>
                        </a>

                    </div>

                </div>

            </div>
        </div>

        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl">
                <div class="p-6 text-gray-900">
                    <div class="text-xl">Transações:</div>

                    <div class="flex flex-col gap-6 mt-5">

                        @foreach ($user->transactions() as $transaction)

                            @if ($transaction->receiver_id == $user->id)
                                <a href="{{ route('transaction.info', ['id' => $transaction->id]) }}" class="flex flex-row gap-8 items-center p-2 pl-4 border rounded-lg border-gray-300 border-green-500">

                                    <div>
                                        @if ($transaction->is_success)
                                            <i class="fa-solid text-lg fa-arrow-trend-up text-green-500"></i>
                                        @else
                                            <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                                        @endif
                                    </div>

                                    <div class="flex-1 flex flex-col">
                                        <x-transaction-description :transaction="$transaction" :user="$user" />
                                        <span class="text-sm font-extralight">{{$transaction->payer_name}}</span>
                                        <span class="text-sm font-light  mt-1 text-green-600">R$ <span class="text-base font-medium"> {{str_replace('.', ',',(string)($transaction->amount / 100))}} </span></span>
                                    </div>

                                </a>

                            @else

                                <a href="{{ route('transaction.info', ['id' => $transaction->id]) }}" class="flex flex-row gap-8 items-center p-2 pl-4 border rounded-lg border-gray-300 border-red-500">
                                    <div>
                                        @if ($transaction->is_success)
                                            <i class="fa-solid text-lg fa-arrow-trend-down text-red-500"></i>
                                        @else
                                            <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                                        @endif
                                    </div>

                                    <div  class="flex-1 flex flex-col">
                                        <x-transaction-description :transaction="$transaction" :user="$user" />
                                        <span class="text-sm font-extralight">{{$transaction->receiver_name}}</span>
                                        <span class="text-sm font-light  mt-1">R$ <span class="text-base font-medium"> -{{str_replace('.', ',',(string)($transaction->amount / 100))}} </span></span>
                                    </div>

                                </a>

                            @endif


                        @endforeach

                    </div>

                </div>

            </div>
        </div>

    </div>

</x-app-layout>
