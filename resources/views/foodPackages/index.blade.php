<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Voedselpakketten') }}
            </h2>

            <a href="{{  route('foodPackages.create') }}" class="inline-block">
                <button class="bg-blue-500 hover:bg-blue-600 p-3 text-white rounded-lg">
                    {{ __('Pakket aanmaken') }}
                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="flex flex-row justify-center">
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md shadow w-[50%]">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flex flex-row justify-center">
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md shadow w-[50%]">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                @if ($foodPackages->isEmpty())
                    <div class="flex flex-row justify-center">
                        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md shadow w-[50%]">
                            {{ __('Er zijn momenteel geen voedselpakketten beschikbaar.') }}
                        </div>
                    </div>
                @else
                    @foreach ($foodPackages as $foodPackage)
                        <div class="bg-gray-200 flex flex-row justify-between items-center p-4 mb-4 w-full rounded-lg">
                            <div class="flex flex-col">
                                <h3 class="font-bold text-lg">{{ $foodPackage['package_number'] }}</h3>
                                <p class="font-thin">{{ $foodPackage['date_composed'] }}</p>
                                <p class="font-thin">{{ $foodPackage['date_issued'] }}</p>
                            </div>
                            <div>
                                <a href="{{  route('foodPackages.show', $foodPackage['foodpackage_id']) }}" class="inline-block">
                                    <button class="bg-blue-500 hover:bg-blue-600 p-3 text-white rounded-lg">
                                        {{ __('Bekijk details') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="mt-4">
                    {{ $foodPackages->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
