<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestaciones SocioEconómicas/Afiliación/Familiares') }}
        </h2>
    </x-slot>
    <div class="py-3">
        <div class="w-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:socioeconomic-benefits.beneficiaries />
            </div>
        </div>
    </div>
</x-app-layout>
