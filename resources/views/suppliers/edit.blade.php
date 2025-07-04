<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Leverancier e-mailadres aanpassen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                @if ($errors->any())
                    <div class="flex flex-row justify-center">
                        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                    @csrf
                    @method('PUT')

                    <!-- Bedrijf Naam -->
                    <div class="mb-5">
                        <label for="company_name" class="block text-gray-700 font-medium mb-2">Bedrijf Naam</label>
                        <input type="text" name="company_name" id="company_name"
                               value="{{ $supplier->company_name }}"
                               readonly
                               class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded border border-gray-300 cursor-not-allowed">
                    </div>

                    <!-- Adres -->
                    <div class="mb-5">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Adres</label>
                        <input type="text" name="address" id="address"
                               value="{{ $supplier->address }}"
                               readonly
                               class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded border border-gray-300 cursor-not-allowed">
                    </div>

                    <!-- Telefoonnummer -->
                    <div class="mb-5">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Telefoonnummer</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ $supplier->contactPerson->phone }}"
                               readonly
                               class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded border border-gray-300 cursor-not-allowed">
                    </div>

                    <!-- E-mailadres -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-medium mb-2">E-mailadres</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $supplier->contactPerson->email) }}"
                               class="w-full px-4 py-2 rounded border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 placeholder-gray-400 @error('email') border-red-500 @enderror">

                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                            Bijwerken
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
