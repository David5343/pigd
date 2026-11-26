<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Prestaciones SocioEconómicas/Afiliación/Familiares de Pensionados') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="w-full">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <livewire:socioeconomic-benefits.pensioner-beneficiaries />
            </div>
        </div>
    </div>
</x-app-layout>
