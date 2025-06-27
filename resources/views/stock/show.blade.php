<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-4">Voorraad detail</h1>
        <div class="mb-2"><strong>Product:</strong> {{ $spStock->Product ?? optional($stock->product)->product_name ?? '-' }}</div>
        <div class="mb-2"><strong>Aantal:</strong> {{ $spStock->Amount ?? $stock->amount }}</div>
        <div class="mb-2"><strong>Categorie:</strong> {{ $spStock->Category ?? optional($stock->product->productCategory)->category_name ?? '-' }}</div>
        <div class="mb-2"><strong>Company:</strong> {{ $spStock->Company ?? optional($stock->product->supplier)->company_name ?? '-' }}</div>
        <div class="mb-2"><strong>Datum aangemaakt:</strong> 
            {{ $spStock->DateCreated ? \Carbon\Carbon::parse($spStock->DateCreated)->format('d-m-Y H:i') : ($stock->date_created ? \Carbon\Carbon::parse($stock->date_created)->format('d-m-Y H:i') : '-') }}
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route('stock.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Terug
            </a>
            <a href="{{ route('stock.edit', $stock->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Bewerken
            </a>
        </div>
    </div>
</x-app-layout>
