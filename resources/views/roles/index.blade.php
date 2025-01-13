<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración General') }}
        </h2> --}}
        @livewire('general-administration.sub-menu-administration')
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-2 py-2">
                <h4>Administración de Roles</h4>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-welcome /> --}}
                <div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                        <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                                            <tr>
                                                <th scope="col" class="px-6 py-4">#</th>
                                                <th scope="col" class="px-6 py-4">First</th>
                                                <th scope="col" class="px-6 py-4">Last</th>
                                                <th scope="col" class="px-6 py-4">Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b border-neutral-200 dark:border-white/10">
                                                <td class="whitespace-nowrap px-6 py-4 font-medium">1</td>
                                                <td class="whitespace-nowrap px-6 py-4">Mark</td>
                                                <td class="whitespace-nowrap px-6 py-4">Otto</td>
                                                <td class="whitespace-nowrap px-6 py-4">@mdo</td>
                                            </tr>
                                            <tr class="border-b border-neutral-200 dark:border-white/10">
                                                <td class="whitespace-nowrap px-6 py-4 font-medium">2</td>
                                                <td class="whitespace-nowrap px-6 py-4">Jacob</td>
                                                <td class="whitespace-nowrap px-6 py-4">Thornton</td>
                                                <td class="whitespace-nowrap px-6 py-4">@fat</td>
                                            </tr>
                                            <tr class="border-b border-neutral-200 dark:border-white/10">
                                                <td class="whitespace-nowrap px-6 py-4 font-medium">3</td>
                                                <td class="whitespace-nowrap px-6 py-4">Larry</td>
                                                <td class="whitespace-nowrap px-6 py-4">Wild</td>
                                                <td class="whitespace-nowrap px-6 py-4">@twitter</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
