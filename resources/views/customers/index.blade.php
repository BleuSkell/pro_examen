<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Klanten</h1>
            <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Klant toevoegen</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Contactpersoon</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Achternaam gezin</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Adres</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Volwassenen</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Kinderen</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Baby's</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Speciale wensen</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Status</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-900">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">
                                @if(isset($customer->contact_first_name))
                                    {{ $customer->contact_first_name }}
                                    {{ $customer->contact_infix ?? '' }}
                                    {{ $customer->contact_last_name }}
                                @else
                                    {{ $customer->familyContactPerson?->first_name ?? '' }}
                                    {{ $customer->familyContactPerson?->infix ?? '' }}
                                    {{ $customer->familyContactPerson?->last_name ?? '' }}
                                @endif
                            </td>
                            <td class="py-3 px-4 border-b">{{ $customer->family_name }}</td>
                            <td class="py-3 px-4 border-b">{{ $customer->address }}</td>
                            <td class="py-3 px-4 border-b">{{ $customer->amount_adults }}</td>
                            <td class="py-3 px-4 border-b">{{ $customer->amount_children ?? 0 }}</td>
                            <td class="py-3 px-4 border-b">{{ $customer->amount_babies ?? 0 }}</td>
                            <td class="py-3 px-4 border-b">
                                <span class="text-sm">{{ Str::limit($customer->special_wishes, 30) }}</span>
                            </td>
                            <td class="py-3 px-4 border-b">
                                @if($customer->is_active ?? true)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Actief</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Inactief</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border-b">
                                <div class="flex space-x-2">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Bekijken</a>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Bewerken</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Verwijderen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 px-4 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Geen klanten gevonden</p>
                                    <p class="text-sm text-gray-400">Voeg je eerste klant toe om te beginnen</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
