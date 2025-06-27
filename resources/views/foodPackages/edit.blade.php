<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Voedselpakket bewerken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="flex flex-row justify-center">
                        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4 w-[50%]">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('foodPackages.update', $foodPackage->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Klantselectie -->
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Klant</label>
                        <select name="customer_id" class="border rounded p-2 w-full" required>
                            <option value="">-- Selecteer klant --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" @if($customer->id == $foodPackage->customer_id) selected @endif>
                                    {{ $customer->family_name }} ({{ $customer->address }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pakketnummer en datum samengesteld -->
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Pakketnummer</label>
                        <input type="text" name="package_number" value="{{ $foodPackage->package_number }}" readonly class="border rounded p-2 w-full bg-gray-100">
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Datum samengesteld</label>
                        <input type="date" name="date_composed" value="{{ $foodPackage->date_composed }}" class="border rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Datum uitgegeven</label>
                        <input type="date" name="date_issued" value="{{ $foodPackage->date_issued }}" class="border rounded p-2 w-full">
                    </div>

                    <!-- Producten toevoegen -->
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Producten</label>
                        <div id="products-list">
                            @foreach($selectedProducts as $i => $selected)
                                <div class="flex mb-2">
                                    <select name="products[{{ $i }}][product_id]" class="border rounded p-2 mr-2 w-2/3">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" @if($product->id == $selected->product_id) selected @endif>
                                                {{ $product->product_name }} ({{ $product->barcode }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="products[{{ $i }}][amount]" min="1" value="{{ $selected->amount }}" class="border rounded p-2 w-1/3" placeholder="Aantal">
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addProductRow()" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">+ Product</button>
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Opslaan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let productIndex = {{ count($selectedProducts) }};
        function addProductRow() {
            const products = @json($products);
            let options = '';
            products.forEach(product => {
                options += `<option value="${product.id}">${product.product_name} (${product.barcode})</option>`;
            });
            const row = `
                <div class="flex mb-2">
                    <select name="products[${productIndex}][product_id]" class="border rounded p-2 mr-2 w-2/3">
                        ${options}
                    </select>
                    <input type="number" name="products[${productIndex}][amount]" min="1" value="1" class="border rounded p-2 w-1/3" placeholder="Aantal">
                </div>
            `;
            document.getElementById('products-list').insertAdjacentHTML('beforeend', row);
            productIndex++;
        }
    </script>
</x-app-layout>