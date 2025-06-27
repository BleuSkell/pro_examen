<x-app-layout>
    <div class="flex items-center justify-between max-w-3xl mx-auto mt-8 mb-8">
        <h1 class="text-2xl font-bold text-center">Voorraad</h1>
        <a href="{{ route('stock.create') }}" class="ml-4 bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded transition">
            Voeg toe +
        </a>
    </div>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-8">
            <div class="space-y-6">
                
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
</x-app-layout>