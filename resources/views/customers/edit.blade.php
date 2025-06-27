<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Klant bewerken</h1>
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
            @csrf
            @method('PUT')

            <!-- Contactpersoon -->
            <div class="mb-4">
                <label for="family_contact_persons_id" class="block font-medium mb-1">Contactpersoon *</label>
                <select id="family_contact_persons_id" name="family_contact_persons_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="">-- Kies contactpersoon --</option>
                    @foreach($familyContactPersons as $person)
                        <option value="{{ $person->id }}" {{ (old('family_contact_persons_id', $customer->family_contact_persons_id) == $person->id) ? 'selected' : '' }}>
                            {{ $person->first_name }} {{ $person->infix }} {{ $person->last_name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('family_contact_persons_id')" class="mt-2" />
            </div>

            <!-- Achternaam gezin -->
            <div class="mb-4">
                <label for="family_name" class="block font-medium mb-1">Achternaam gezin *</label>
                <input id="family_name" name="family_name" type="text" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('family_name', $customer->family_name) }}" required>
                <x-input-error :messages="$errors->get('family_name')" class="mt-2" />
            </div>

            <!-- Adres -->
            <div class="mb-4">
                <label for="address" class="block font-medium mb-1">Adres *</label>
                <input id="address" name="address" type="text" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('address', $customer->address) }}" required>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Volwassenen -->
            <div class="mb-4">
                <label for="amount_adults" class="block font-medium mb-1">Aantal volwassenen *</label>
                <input id="amount_adults" name="amount_adults" type="number" min="0" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('amount_adults', $customer->amount_adults) }}" required>
                <x-input-error :messages="$errors->get('amount_adults')" class="mt-2" />
            </div>

            <!-- Kinderen -->
            <div class="mb-4">
                <label for="amount_children" class="block font-medium mb-1">Aantal kinderen</label>
                <input id="amount_children" name="amount_children" type="number" min="0" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('amount_children', $customer->amount_children ?? 0) }}">
                <x-input-error :messages="$errors->get('amount_children')" class="mt-2" />
            </div>

            <!-- Baby's -->
            <div class="mb-4">
                <label for="amount_babies" class="block font-medium mb-1">Aantal baby's</label>
                <input id="amount_babies" name="amount_babies" type="number" min="0" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('amount_babies', $customer->amount_babies ?? 0) }}">
                <x-input-error :messages="$errors->get('amount_babies')" class="mt-2" />
            </div>

            <!-- Speciale wensen -->
            <div class="mb-4">
                <label for="special_wishes" class="block font-medium mb-1">Speciale wensen</label>
                <textarea id="special_wishes" name="special_wishes" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('special_wishes', $customer->special_wishes) }}</textarea>
                <x-input-error :messages="$errors->get('special_wishes')" class="mt-2" />
            </div>

            <!-- Is Active -->
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_active', $customer->is_active ?? true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Klant is actief</span>
                </label>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuleren</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bijwerken</button>
            </div>
        </form>
    </div>
</x-app-layout>