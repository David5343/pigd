<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl leading-tight text-[#651F34]">
                Coordinación Médica / Titulares / Expediente electrónico
            </h2>
            <a href="{{ route('membership_medical.index') }}"
                class="inline-flex items-center rounded-md border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <main class="min-h-screen bg-[#F7F3EC] py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @include('medical_coordination.membership.partials.expedient-content', $expediente)
        </div>
    </main>
</x-app-layout>
