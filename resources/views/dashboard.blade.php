<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="w-full">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
