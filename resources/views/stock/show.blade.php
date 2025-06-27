<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-4">Voorraad detail</h1>
        <div class="mb-2"><strong>Product:</strong> {{ optional($stock->product)->product_name ?? '-' }}</div>
        <div class="mb-2"><strong>Aantal:</strong> {{ $stock->amount }}</div>
        <div class="mb-2"><strong>Categorie:</strong> {{ optional($stock->product->productCategory)->category_name ?? '-' }}</div>
        <div class="mb-2"><strong>Company:</strong> {{ optional($stock->product->supplier)->company_name ?? '-' }}</div>
        <div class="mb-2"><strong>Datum aangemaakt:</strong> {{ $stock->date_created ? \Carbon\Carbon::parse($stock->date_created)->format('d-m-Y H:i') : '-' }}</div>
        <a href="{{ route('stock.index') }}" class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Terug</a>
    </div>
</x-app-layout>
