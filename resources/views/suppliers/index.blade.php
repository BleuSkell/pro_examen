<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Overzicht Leverancier
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                <!-- Header with title + button -->
                <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                    <h1 class="text-2xl font-semibold text-gray-800">Overzicht Leverancier</h1>
                    <a href="{{ route('suppliers.create') }}"
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        + Voeg Leverancier Toe
                    </a>
                </div>

                <!-- Success message -->
                @if(session('success'))
                    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if($suppliers->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 text-sm sm:text-base">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 text-left">Bedrijf Naam</th>
                                    <th class="px-6 py-3 text-left">Adres</th>
                                    <th class="px-6 py-3 text-left">Telefoonnummer</th>
                                    <th class="px-6 py-3 text-left">E-mail</th>
                                    <th class="px-6 py-3 text-left">Levering</th>
                                    <th class="px-6 py-3 text-left">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($suppliers as $supplier)
                                    <tr class="border-t hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->company_name }}</td>
                                        <td class="px-6 py-4">{{ $supplier->address }}</td>
                                        <td class="px-6 py-4">{{ $supplier->contactPerson->phone ?? '—' }}</td>
                                        <td class="px-6 py-4">{{ $supplier->contactPerson->email ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            {{ $supplier->next_delivery_date ?? 'n.v.t.' }}
                                            {{ $supplier->next_delivery_time ? \Carbon\Carbon::parse($supplier->next_delivery_time)->format('H:i') : '' }}
                                        </td>
                                        <td class="px-6 py-4 space-x-2">
                                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                               class="text-blue-600 hover:underline">Wijzig</a>
                                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        onclick="window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { form: this.closest('form') } }))"
                                                        class="text-red-600 hover:underline">
                                                    Verwijder
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-6 text-center">
                            {{ $suppliers->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-500 mt-6">Geen resultaten beschikbaar</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Verwijder Bevestigingsmodaal -->
    <div x-data="{ open: false, form: null }" @open-delete-modal.window="open = true; form = $event.detail.form"
         x-show="open"
         x-cloak
         class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
            <p class="text-gray-800 text-lg font-medium mb-4">Weet u zeker dat u deze leverancier wilt verwijderen?</p>
            <div class="flex justify-end space-x-3">
                <button @click="open = false"
                        class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">
                    Annuleren
                </button>
                <button @click="form.submit()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Bevestig
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine.js (indien nog niet beschikbaar in layout) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
