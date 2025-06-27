<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Voorraad') }}
            </h2>

            <a href="{{ route('stock.create') }}" class="inline-block">
                <button class="bg-blue-500 hover:bg-blue-600 p-3 text-white rounded-lg">
                    {{ __('Voeg toe +') }}
                </button>
            </a>
        </div>
    </x-slot>

    <div class="flex flex-col items-center max-w-3xl mx-auto mt-8 mb-8">
        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600 font-semibold">
                {{ session('error') }}
            </div>
        @endif
        <button
            id="toggleDataBtn"
            class="mb-4 bg-gray-500 hover:bg-gray-600 text-black font-semibold py-2 px-4 rounded transition"
            onclick="toggleStockData()"
            type="button"
        >
            Toon data
        </button>
        <div id="noDataMsg" class="mb-4 text-red-600 hidden">
            Geen data beschikbaar, probeer het later opnieuw.
        </div>
    </div>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-8">
            <div id="stockData" class="space-y-6 hidden">
                @foreach($stocks as $stock)
                    <div class="bg-gray-200 rounded-lg flex justify-between items-center p-6">
                        <div>
                            <div class="font-bold text-lg mb-1">
                                {{ optional($stock->product)->product_name ?? '-' }}
                            </div>
                            <div class="text-base">
                                Datum aangemaakt<br>
                                {{ $stock->date_created ? \Carbon\Carbon::parse($stock->date_created)->format('d-m-Y H:i') : '-' }}
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('stock.show', $stock->id) }}" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-6 rounded transition">
                                Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function toggleStockData() {
            const dataDiv = document.getElementById('stockData');
            const btn = document.getElementById('toggleDataBtn');
            const msg = document.getElementById('noDataMsg');
            if (dataDiv.classList.contains('hidden')) {
                dataDiv.classList.remove('hidden');
                msg.classList.add('hidden');
                btn.textContent = 'Verberg data';
            } else {
                dataDiv.classList.add('hidden');
                msg.classList.remove('hidden');
                btn.textContent = 'Toon data';
            }
        }
        // Toon melding als er een success-melding is (na aanmaken, bijwerken of verwijderen)
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    let greenMsg = document.querySelector('.mb-4.text-green-600');
                    let redMsg = document.querySelector('.mb-4.text-red-600');
                    if (greenMsg) greenMsg.classList.add('hidden');
                    if (redMsg) redMsg.classList.add('hidden');
                }, 3000);
            });
        @endif
    </script>
</x-app-layout>