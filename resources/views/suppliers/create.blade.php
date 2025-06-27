<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuwe Leverancier aanmaken
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">

                <form method="POST" action="{{ route('suppliers.store') }}">
                    @csrf

                    <!-- Bedrijfsnaam -->
                    <div class="mb-5">
                        <label for="company_name" class="block text-gray-700 font-medium mb-2">
                            Bedrijf Naam
                        </label>
                        <input type="text" name="company_name" id="company_name"
                               placeholder="Schrijf hier je bedrijfsnaam"
                               value="{{ old('company_name') }}"
                               class="w-full px-4 py-2 rounded border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 placeholder-gray-400 @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Adres -->
                    <div class="mb-5">
                        <label for="address" class="block text-gray-700 font-medium mb-2">
                            Adres
                        </label>
                        <input type="text" name="address" id="address"
                               placeholder="Voer hier je adres in"
                               value="{{ old('address') }}"
                               class="w-full px-4 py-2 rounded border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 placeholder-gray-400 @error('address') border-red-500 @enderror">
                        @error('address')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefoonnummer -->
                    <div class="mb-5">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">
                            Telefoonnummer
                        </label>
                        <input type="text" name="phone" id="phone"
                               placeholder="Voer hier je telefoonnummer in"
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-2 rounded border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 placeholder-gray-400 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- E-mailadres -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-medium mb-2">
                            E-mailadres
                        </label>
                        <input type="email" name="email" id="email"
                               placeholder="Vul hier jouw e-mailadres in"
                               value="{{ old('email') }}"
                               class="w-full px-4 py-2 rounded border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 placeholder-gray-400 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                            Opslaan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Alleen letters + spaties
        document.getElementById('company_name').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
        });

        document.getElementById('address').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-z0-9À-ÿ\s]/g, '');
        });

        // Alleen cijfers en optioneel +
        document.getElementById('phone').addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });

        // Alleen a-z, A-Z, 0-9, @, ., _
        document.getElementById('email').addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-z0-9@._]/g, '');
        });
    </script>
</x-app-layout>
