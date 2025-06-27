<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Overzicht Leverancier
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 sm:p-6 text-white">

                <!-- Flex container met justify-between en flex-wrap zodat knop rechts blijft -->
                <div class="flex justify-between items-center mb-4 gap-3 flex-wrap">
                    <h1 class="text-lg sm:text-xl font-bold">Overzicht Leverancier</h1>
                    <a href="{{ route('suppliers.create') }}" 
                       class="text-sm sm:text-base underline hover:text-blue-400 transition whitespace-nowrap">
                        Voeg Leverancier
                    </a>
                </div>

                @if($suppliers->count())
                    <div class="overflow-x-auto">
                        <table class="">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">Bedrijf Naam</th>
                                    <th class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">Adres</th>
                                    <th class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">Telefoonnummer</th>
                                    <th class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">E-mailAdres</th>
                                    <th class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">Levering</th>
                                    <th class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                   <tr class="border-t border-gray-300 hover:bg-gray-800 transition-colors duration-200">

                                        <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm sm:text-base">{{ $supplier->company_name }}</td>
                                        <td class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">{{ $supplier->address }}</td>
                                        <td class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">{{ $supplier->contactPerson->phone ?? '—' }}</td>
                                        <td class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">{{ $supplier->contactPerson->email ?? '—' }}</td>
                                        <td class="px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base">
                                            {{ $supplier->next_delivery_date ?? 'n.v.t.' }}
                                            {{ $supplier->next_delivery_time ? \Carbon\Carbon::parse($supplier->next_delivery_time)->format('H:i') : '' }}
                                        </td>
                                        <td class="px-3 py-2 sm:px-4 sm:py-3 space-x-2 text-sm sm:text-base">
                                            <a href="#" 
                                               class="text-blue-600 hover:underline inline-block px-2 py-1 rounded hover:bg-blue-100 transition">
                                                wijzig
                                            </a>
                                            <form action="#" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:underline inline-block px-2 py-1 rounded hover:bg-red-100 transition"
                                                        onclick="return confirm('Weet je zeker dat je deze leverancier wilt verwijderen?');">
                                                    verwijder
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Hier is de paginatie met text-white zodat de tekst wit wordt -->
                        <div class="mt-4 text-center text-white">
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
