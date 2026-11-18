<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-semibold leading-tight text-slate-600">
            {{ __('Coordinación Médica/Familiares') }}
        </h2>
    </x-slot>
    <div class="py-3">
        <div class="w-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:medical-coordination.beneficiaries />
            </div>
        </div>
    </div>
</x-app-layout>
