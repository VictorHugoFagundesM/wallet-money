<x-app-layout>

    <div class="py-12 max-w-[1200px] mr-auto ml-auto">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-6">

                <div class="text-2xl mb-5">
                    <a href="{{ route('bank-slip.payment') }}">
                        <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                    </a>

                    Confira os dados do pagamento

                </div>

                <div class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col">
                    <div>Saldo:</div>
                    <div class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center">
                        R$ {{str_replace('.', ',',(string)($user->balance / 100))}}
                    </div>
                </div>

                <form method="post" action="{{ route('transaction.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')

                    <input type="hidden" name="bank_slip_id" value="{{$bankSlip->id}}">
                    <input type="hidden" name="amount" value="{{$bankSlip->amount}}">

                    <span class="justify-center flex w-[100%] font-medium text-center mt-6 mb-5">{{$bankSlip->name}}</span>

                    <div class="flex">
                        <i class="fa-regular fa-file text-gray-500 text-6xl ml-auto mr-auto mb-5"></i>
                    </div>

                    <div class="flex-1 flex flex-col">
                        <span class="justify-center flex w-[100%] text-xl text-center mt-5 mb-">R$ <span class="text-base text-xl ml-2"> {{str_replace('.', ',',(string)($bankSlip->amount / 100))}} </span></span>
                    </div>

                    <div class="max-w-[100%] border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center mt-5 relative">
                        {{$bankSlip->code}}
                    </div>


                    <div class="flex items-center gap-4">
                        <x-primary-button class="flex-1 flex justify-center">{{ __('Pagar') }}</x-primary-button>

                        @if (session('status') === 'transaction-created')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

