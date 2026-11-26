<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Prestaciones SocioEconómicas/Afiliación/Pensionados') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="w-full">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <livewire:socioeconomic-benefits.pensioners />
            </div>
        </div>
    </div>
</x-app-layout>
