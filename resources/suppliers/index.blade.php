<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Overzicht Leverancier
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">

                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-lg font-bold">Overzicht Leverancier</h1>
                    <a href="{{ route('suppliers.create') }}" class="text-sm underline">voeg Leverancier</a>
                </div>

                @if($suppliers->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left bg-gray-200 text-black rounded">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Bedrijf Naam</th>
                                    <th class="px-4 py-2">Adres</th>
                                    <th class="px-4 py-2">Telefoonnummer</th>
                                    <th class="px-4 py-2">E-mailAdres</th>
                                    <th class="px-4 py-2">Levering</th>
                                    <th class="px-4 py-2">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    <tr class="border-t border-gray-300">
                                        <td class="px-4 py-2">{{ $supplier->company_name }}</td>
                                        <td class="px-4 py-2">{{ $supplier->address }}</td>
                                        <td class="px-4 py-2">{{ $supplier->contactPerson->phone ?? '—' }}</td>
                                        <td class="px-4 py-2">{{ $supplier->contactPerson->email ?? '—' }}</td>
                                        <td class="px-4 py-2">
                                            {{ $supplier->next_delivery_date ?? 'n.v.t.' }}
                                            {{ $supplier->next_delivery_time ? \Carbon\Carbon::parse($supplier->next_delivery_time)->format('H:i') : '' }}
                                        </td>
                                        <td class="px-4 py-2 space-x-2">
                                            <a href="#" class="text-blue-600 hover:underline">wijzig</a>
                                            <form action="#" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">verwijder</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4 text-center">
                            {{ $suppliers->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center text-white mt-4">Geen resultaten beschikbaar</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
