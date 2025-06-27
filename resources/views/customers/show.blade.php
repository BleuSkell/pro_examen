<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Klantgegevens</h1>
        <div class="bg-white shadow rounded p-6">
            <dl class="divide-y divide-gray-200">
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Contactpersoon</dt>
                    <dd>
                        {{ $customer->familyContactPerson?->first_name }}
                        {{ $customer->familyContactPerson?->infix }}
                        {{ $customer->familyContactPerson?->last_name }}
                    </dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Achternaam gezin</dt>
                    <dd>{{ $customer->family_name }}</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Adres</dt>
                    <dd>{{ $customer->address }}</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Aantal volwassenen</dt>
                    <dd>{{ $customer->amount_adults }}</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Aantal kinderen</dt>
                    <dd>{{ $customer->amount_children }}</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Aantal baby's</dt>
                    <dd>{{ $customer->amount_babies }}</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Speciale wensen</dt>
                    <dd>{{ $customer->special_wishes }}</dd>
                </div>
            </dl>
            <hr class="my-6">
            <h2 class="text-xl font-semibold mb-4">Contactpersoon informatie</h2>
            @if($customer->familyContactPerson && $customer->familyContactPerson->contactPerson)
                <dl class="divide-y divide-gray-200">
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium">Naam</dt>
                        <dd>
                            {{ $customer->familyContactPerson->contactPerson->first_name }}
                            {{ $customer->familyContactPerson->contactPerson->infix }}
                            {{ $customer->familyContactPerson->contactPerson->last_name }}
                        </dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium">E-mail</dt>
                        <dd>{{ $customer->familyContactPerson->contactPerson->email }}</dd>
                    </div>
                    <div class="py-2 flex justify-between">
                        <dt class="font-medium">Telefoon</dt>
                        <dd>{{ $customer->familyContactPerson->contactPerson->phone }}</dd>
                    </div>
                </dl>
            @else
                <p class="text-gray-500">Geen contactpersoon informatie beschikbaar.</p>
            @endif
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('customers.edit', $customer) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug</a>
            </div>
        </div>
    </div>
</x-app-layout>
