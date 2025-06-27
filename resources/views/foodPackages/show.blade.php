<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Voedselpakket details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="flex flex-row justify-center">
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md shadow w-[50%]">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <div>
                    <h3 class="font-bold text-lg mb-2">Pakket: {{ $packageDetails['package_number'] }}</h3>
                    <p><strong>Datum samengesteld:</strong> {{ $packageDetails['date_composed'] }}</p>
                    <p><strong>Datum uitgegeven:</strong> {{ $packageDetails['date_issued'] }}</p>
                    <hr class="my-4">
                </div>

                <div>
                    <h4 class="font-semibold">Klantgegevens</h4>
                    <p><strong>Naam:</strong> {{ $packageDetails['family_name'] }}</p>
                    <p><strong>Adres:</strong> {{ $packageDetails['address'] }}</p>
                    <p><strong>Volwassenen:</strong> {{ $packageDetails['amount_adults'] }}</p>
                    <p><strong>Kinderen:</strong> {{ $packageDetails['amount_children'] }}</p>
                    <p><strong>Baby's:</strong> {{ $packageDetails['amount_babies'] }}</p>
                    <p><strong>Speciale wensen:</strong> {{ $packageDetails['special_wishes'] }}</p>
                    <hr class="my-4">
                </div>

                <div>
                    <h4 class="font-semibold">Contactpersoon</h4>
                    <p><strong>Naam:</strong> {{ $packageDetails['first_name'] }} {{ $packageDetails['infix'] }} {{ $packageDetails['last_name'] }}</p>
                    <p><strong>Relatie:</strong> {{ $packageDetails['relation'] }}</p>
                    <p><strong>Email:</strong> {{ $packageDetails['family_email'] }}</p>
                    <p><strong>Telefoon:</strong> {{ $packageDetails['family_phone'] }}</p>
                    <hr class="my-4">
                </div>

                <div>
                    <h4 class="font-semibold">Producten in pakket</h4>
                    <ul>
                        @foreach ($products as $product)
                            <li>
                                <strong>{{ $product['product_name'] }}</strong> ({{ $product['barcode'] }}) - Aantal: {{ $product['amount'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex flex-row justify-between mt-4">
                    <a href="{{ route('foodPackages.edit', $packageDetails['food_package_id']) }}" class="inline-block">
                        <button class="bg-blue-500 hover:bg-blue-600 p-3 text-white rounded-lg">
                            {{ __('Bewerken') }}
                        </button>
                    </a>

                    <form method="POST" action="{{ route('foodPackages.destroy', $packageDetails['food_package_id']) }}" onsubmit="return confirm('Weet je zeker dat je dit pakket wilt verwijderen?');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 p-3 text-white rounded-lg">
                            {{ __('Verwijderen') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>