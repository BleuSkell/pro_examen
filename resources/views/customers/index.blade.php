<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Klanten</h1>
            <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Klant toevoegen</a>
        </div>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Contactpersoon</th>
                    <th class="py-2 px-4 border-b">Achternaam gezin</th>
                    <th class="py-2 px-4 border-b">Adres</th>
                    <th class="py-2 px-4 border-b">Volwassenen</th>
                    <th class="py-2 px-4 border-b">Kinderen</th>
                    <th class="py-2 px-4 border-b">Baby's</th>
                    <th class="py-2 px-4 border-b">Speciale wensen</th>
                    <th class="py-2 px-4 border-b">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="py-2 px-4 border-b">
                            {{ $customer->family_contact_first_name }}
                            {{ $customer->family_contact_infix }}
                            {{ $customer->family_contact_last_name }}
                        </td>
                        <td class="py-2 px-4 border-b">{{ $customer->family_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->address }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->amount_adults }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->amount_children }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->amount_babies }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer->special_wishes }}</td>
                        <td class="py-2 px-4 border-b flex space-x-2">
                            <a href="{{ route('customers.show', $customer->id) }}" class="text-blue-500 hover:underline">Bekijken</a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-500 hover:underline">Bewerken</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Weet je het zeker?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 px-4 text-center text-gray-500">Geen klanten gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
