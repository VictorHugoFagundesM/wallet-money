<x-app-layout>
    <div class="py-12 max-w-[1200px] mr-auto ml-auto">

        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl">

                <div class="p-6 text-gray-900">

                    <div class="flex text-2xl mb-5">
                        <a href="{{ route("home") }}">
                            <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                        </a>
                        Boletos

                        <a
                            href="{{ route('bank-slip.create') }}"
                            class="ml-auto inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        >
                            Gerar
                        </a>

                    </div>

                    <form method="get" action="{{ route('bank-slip.index') }}" class="mt-6 space-y-6">
                        <div class="flex gap-4 flex-col">
                            <x-text-input id="update_amount" name="search" type="text" class="mt-1 block w-full" value="{{request()->input('search')}}"/>
                            <x-primary-button class="ml-auto">{{ __('Pesquisar') }}</x-primary-button>
                        </div>
                    </form>

                    <div class="flex flex-col gap-6 mt-5">

                        @foreach ($bankSlips as $bankSlip)

                            <a href="{{ route('bank-slip.info', ['id' => $bankSlip->id]) }}" class="flex flex-row gap-8 items-center p-2 pl-4 border rounded-lg border-gray-500">

                                <div>
                                    @if ($bankSlip->is_payed)
                                        <i class="fa-regular text-xl fa-file text-green-500"></i>
                                    @else
                                        <i class="fa-regular fa-file text-gray-500 text-xl"></i>

                                    @endif
                                </div>

                                <div class="flex-1 flex flex-col">
                                    @if ($bankSlip->is_payed)
                                        <span class="mb-2 font-light">Depósito Recebido</span>
                                    @endif
                                    <span class="text-sm font-extralight">{{$bankSlip->name}}</span>
                                    <span class="text-sm font-light  mt-1 text-gray-600">R$ <span class="text-base font-medium"> {{str_replace('.', ',',(string)($bankSlip->amount / 100))}} </span></span>
                                </div>

                            </a>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>

