<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">

                <!-- 🟥 Validatiefouten bovenaan -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-300 text-red-800 px-6 py-4 rounded-md shadow-sm">
                        <h3 class="font-semibold mb-2">Er zijn fouten gevonden:</h3>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- 📅 Formulier -->
                <form method="GET" action="{{ route('dashboard') }}" class="mb-8">
                    <div class="flex flex-wrap gap-6 items-end">
                        <!-- Maand -->
                        <div class="w-40">
                            <label for="month" class="block mb-2 text-sm font-medium text-gray-700">Maand</label>
                            <select name="month" id="month" class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Kies maand --</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Jaar -->
                        <div class="w-40">
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-700">Jaar</label>
                            <select name="year" id="year" class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Kies jaar --</option>
                                @for ($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Knop -->
                        <div>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                                Toon rapport
                            </button>
                        </div>
                    </div>
                </form>

                <!-- 📊 Rapport tonen -->
                @if (isset($reportData) && count($reportData) > 0)
                    <h3 class="text-xl font-semibold mb-6 text-gray-800 border-b pb-2">Maandoverzicht</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg shadow-sm">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700">Categorie</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700">Postcode</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700">Leveringen</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-700">Voedselpakketten</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($reportData as $item)
                                    <tr>
                                        <td class="px-6 py-4">{{ $item->category }}</td>
                                        <td class="px-6 py-4">{{ $item->postcode }}</td>
                                        <td class="px-6 py-4">{{ $item->deliveries }}</td>
                                        <td class="px-6 py-4">{{ $item->food_packages }}</td>
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
