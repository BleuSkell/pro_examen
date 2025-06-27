<x-app-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-700">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-8">
            <form action="{{ route('stock.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-semibold mb-2" for="company_name">Company naam</label>
                    <input type="text" name="company_name" id="company_name" required
                        placeholder="Typ een company naam"
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <div>
                    <label class="block font-semibold mb-2" for="product_name">Product naam</label>
                    <input type="text" name="product_name" id="product_name" required
                        placeholder="Typ een productnaam"
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <div>
                    <label class="block font-semibold mb-2" for="amount">Aantal</label>
                    <input type="number" name="amount" id="amount" min="0" required
                        placeholder="aantal"
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <div>
                    <label class="block font-semibold mb-2" for="categorie">Categorie</label>
                    <select name="categorie" id="categorie" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Kies een categorie</option>
                        <option value="groenten">Groenten</option>
                        <option value="fruit">Fruit</option>
                        <option value="vlees">Vlees</option>
                        <option value="vis">Vis</option>
                        <option value="zuivel">Zuivel</option>
                        <option value="granen">Granen</option>
                        <option value="dranken">Dranken</option>
                        <option value="snacks">Snacks</option>
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
