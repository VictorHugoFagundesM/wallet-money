<x-app-layout>
    <div class="py-12">
        <div class="max-w-[90%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-6">

            <div class="text-2xl mb-5">
                <a href="{{ url("/bank-slip") }}">
                    <i class="fa-solid fa-arrow-left-long text-xl text-gray-600 mr-2"></i>
                </a>
                Boleto
            </div>

            <span class="justify-center flex w-[100%] font-medium text-center mt-6 mb-5">{{$bankSlip->name}}</span>

            <div class="flex">
                @if ($bankSlip->is_payed)
                    <i class="fa-regular text-6xl fa-file text-green-500 ml-auto mr-auto mb-5"></i>
                @else
                    <i class="fa-regular fa-file text-gray-500 text-6xl ml-auto mr-auto mb-5"></i>

                @endif
            </div>

            <div class="flex-1 flex flex-col">
                @if ($bankSlip->is_payed)
                    <span class="mb-2 font-light">Depósito Recebido</span>
                @endif
                <span class="justify-center flex w-[100%] text-xl text-center mt-5 mb-">R$ <span class="text-base text-xl ml-2"> {{str_replace('.', ',',(string)($bankSlip->amount / 100))}} </span></span>
            </div>

            <div class="max-w-[100%] border flex-1 rounded-lg border-gray-300 p-2 flex flex-col items-center mt-5 relative">
                {{$bankSlip->code}}
                <i class="fa-regular fa-copy absolute top-1 right-1 bg-white p-2" onclick="navigator.clipboard.writeText('{{ $bankSlip->code }}')"></i>
            </div>

        </div>
    </div>
</x-app-layout>

