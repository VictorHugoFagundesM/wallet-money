<x-app-layout>

    <div class="py-12 max-w-[1200px] mr-auto ml-auto">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-6">

                <div class="text-2xl mb-5">
                    <a href="{{ url("/bank-slip") }}">
                        <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                    </a>

                    Gerar Boleto

                </div>

                <form method="post" action="{{ route('bank-slip.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')

                    <div>
                        <x-input-label for="update_name" :value="__('Título do boleto')" />
                        <x-text-input id="update_name" name="name" type="text" class="mt-1 block w-full" maxlength="50" required/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="update_amount" :value="__('Valor')" />
                        <x-text-input id="update_amount" name="amount" type="text" class="mt-1 block w-full" id="money_mask" required/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="flex-1 flex justify-center">{{ __('Gerar') }}</x-primary-button>

                        @if (session('status') === 'bank-slip-created')
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

