<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Voedselpakketten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @foreach ($foodPackages as $foodPackage)
                    <div class="bg-gray-200 flex flex-row justify-between items-center p-4 mb-4 w-full rounded-lg">
                        <div class="flex flex-col">
                            <h3 class="font-bold text-lg">{{ $foodPackage->package_number }}</h3>
                            <p class="font-thin">{{ $foodPackage->date_composed }}</p>
                            <p class="font-thin">{{ $foodPackage->date_issued }}</p>
                        </div>

                        <div>
                            <a href="">
                                <button class="bg-blue-500 hover:bg-blue-600 p-3 text-white rounded-lg">
                                    {{ __('Bekijk details') }}
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
