<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Leverancier e-mailadres aanpassen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 text-white shadow-md overflow-hidden sm:rounded-lg p-6">
                <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="company_name">Bedrijf Naam</label>
                        <input type="text" name="company_name"
                               value="{{ $supplier->company_name }}"
                               class="w-full px-4 py-2 text-black focus:text-black bg-gray-200 rounded border" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="address">Adres</label>
                        <input type="text" name="address"
                               value="{{ $supplier->address }}"
                               class="w-full px-4 py-2 text-black focus:text-black bg-gray-200 rounded border" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="phone">Telefoonnummer</label>
                        <input type="text" name="phone"
                               value="{{ $supplier->contactPerson->phone }}"
                               class="w-full px-4 py-2 text-black focus:text-black bg-gray-200 rounded border" readonly>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-1" for="email">E-mailAdres</label>
                        <input type="email" name="email" value="{{ old('email', $supplier->contactPerson->email) }}"
                               class="w-full px-4 py-2 text-black focus:text-black placeholder-gray-500 rounded border @error('email') border-red-500 @enderror">
                        @error('email')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 w-full rounded">
                            Bijwerken
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
