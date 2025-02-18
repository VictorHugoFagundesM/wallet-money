<x-app-layout>

    <div class="py-12">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-6">

                <div class="text-2xl mb-5">
                    <a href="{{ url("/home") }}">
                        <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                    </a>
                    Solicitar Estorno
                </div>

                <div class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col">
                    <div>Valor:</div>
                    <div class="border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center">
                        R$ {{str_replace('.', ',',(string)($transaction->amount / 100))}}
                    </div>
                </div>

                <form method="post" action="{{ route('refund.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')

                    <div>
                        <x-input-label for="update_reason" :value="__('Motivo')" />
                        <textarea name="reason" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="flex-1 flex justify-center">{{ __('Enviar') }}</x-primary-button>

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

