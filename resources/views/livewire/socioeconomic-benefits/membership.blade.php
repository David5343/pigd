<div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            PIGD
        </h1>

        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <input type="text" wire:model.live="search">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                                <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Folio</th>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">RFC</th>
                                    <th scope="col" class="px-6 py-4">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($lista->count())
                                    @foreach ($lista as $item)
                                        <tr class="border-b border-neutral-200 dark:border-white/10">
                                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $item->id }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $item->file_number }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $item->last_name_1 . ' ' . $item->last_name_2 . ' ' . $item->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $item->rfc }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $item->id }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
                {{ $lista->links() }}
            </div>
        </div>
    </div>
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"></div>
</div>
