<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">

                <!-- Formulier -->
                <form method="GET" action="{{ route('dashboard') }}" class="mb-8">
                    @csrf
                    <div class="flex flex-wrap gap-6 items-end">
                        <div class="w-40">
                            <label for="month" class="block mb-2 text-sm font-medium text-gray-700">Maand</label>
                            <select name="month" id="month" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Kies maand --</option>
                                @for ($m=1; $m<=12; $m++)
                                    <option value="{{ $m }}" {{ (request('month') == $m) ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            @error('month')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-40">
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-700">Jaar</label>
                            <select name="year" id="year" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Kies jaar --</option>
                                @for ($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ (request('year') == $y) ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            @error('year')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition">
                                Toon rapport
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Rapport tonen als data aanwezig is -->
                @if(isset($reportData) && count($reportData) > 0)
                    <h3 class="text-xl font-semibold mb-6 text-gray-800 border-b border-gray-200 pb-2">Maandoverzicht</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg shadow-sm overflow-hidden">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700 uppercase tracking-wider border-b border-blue-100">Productcategorie</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700 uppercase tracking-wider border-b border-blue-100">Postcode</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700 uppercase tracking-wider border-b border-blue-100">Aantal leveringen</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700 uppercase tracking-wider border-b border-blue-100">Aantal voedselpakketten</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($reportData as $item)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->postcode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->deliveries }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->food_packages }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif(request()->has('month') || request()->has('year'))
                    <p class="text-red-600 mt-6 text-center font-semibold">Geen data gevonden voor de geselecteerde maand en jaar.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
