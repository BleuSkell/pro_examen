<x-app-layout>
    <div class="flex items-center justify-between max-w-3xl mx-auto mt-8 mb-8">
        <h1 class="text-2xl font-bold text-center">Voorraad Bewerken</h1>
    </div>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-8">
            {{-- Toon validatiefouten --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('stock.update', $stock->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-2" for="company_name">Company naam</label>
                    <select name="company_name" id="company_name" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Kies een company</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->company_name }}"
                                @if($stock->product && $stock->product->supplier && $stock->product->supplier->company_name == $supplier->company_name) selected @endif>
                                {{ $supplier->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2" for="product_name">Product naam</label>
                    <input type="text" name="product_name" id="product_name"
                        value="{{ old('product_name', optional($stock->product)->product_name) }}" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block font-semibold mb-2" for="categorie">Categorie</label>
                    <select name="categorie" id="categorie" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Kies een categorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @if($stock->product && $stock->product->productCategory && $stock->product->productCategory->id == $category->id) selected @endif>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2" for="amount">Aantal</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $stock->amount) }}" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('stock.index') }}" class="mr-4 text-gray-500 hover:underline">Annuleren</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                        Bijwerken
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
