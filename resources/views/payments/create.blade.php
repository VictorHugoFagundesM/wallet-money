<x-app-layout>

    <div class="py-12 max-w-[1200px] mr-auto ml-auto">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-6">
                <div class="text-2xl mb-5">
                    <a href="{{ route("home") }}">
                        <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                    </a>
                    Pagar boleto
                </div>

                <div class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col">
                    <div>Saldo:</div>
                    <div class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center">
                        R$ {{str_replace('.', ',',(string)($user->balance / 100))}}
                    </div>
                </div>

                <form method="post" action="{{ route('payment.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')

                    <div>
                        <x-input-label for="update_code" :value="__('Linha digitável')" />
                        <x-text-input id="update_code" name="code" type="text" class="mt-1 block w-full" maxlength="12" required/>
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="update_amount" :value="__('Valor')" />
                        <x-text-input id="update_amount" name="amount" type="text" class="mt-1 block w-full" id="money_mask" required/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="flex-1 flex justify-center">{{ __('Enviar') }}</x-primary-button>

                        @if (session('status') === 'payment-created')
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

