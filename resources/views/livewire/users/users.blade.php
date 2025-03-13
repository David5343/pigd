<div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            PIGD
        </h1>
        <div class="text-right">
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center gap-2 rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal bg-neutral-100 text-neutral-700 transition duration-150 ease-in-out hover:bg-blue-300 hover:text-blue-600 focus:text-blue-600 focus:outline-none focus:ring-0 active:text-primary-700 dark:hover:bg-neutral-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                NUEVO USUARIO
            </a>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="relative">
                        <input wire:model.live="search" type="search"
                            class="relative m-0 block w-full rounded border border-solid border-neutral-200 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-primary focus:shadow-inset focus:outline-none motion-reduce:transition-none dark:border-white/10 dark:text-white dark:placeholder:text-neutral-200 dark:autofill:shadow-autofill dark:focus:border-primary"
                            placeholder="Busca por Nombre o Usuario" aria-label="Search"
                            id="exampleFormControlInput4" />
                    </div>
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                                <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Usuario</th>
                                    <th scope="col" class="px-6 py-4">Rol</th>
                                    <th scope="col" class="px-6 py-4">Api Token</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count())
                                    @foreach ($users as $item)
                                        <tr class="border-b border-neutral-200 dark:border-white/10">
                                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $item->id }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $item->name }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $item->email }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $item->roles->pluck('name')->implode(', ') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                <button type="button" data-twe-toggle="modal"
                                                    data-twe-target="#staticBackdrop" data-twe-ripple-init
                                                    data-twe-ripple-color="light">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                                    </svg>

                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- Modal -->
                        <div data-twe-modal-init
                            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                            id="staticBackdrop" data-twe-backdrop="static" data-twe-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div data-twe-modal-dialog-ref
                                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                                <div
                                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
                                    <div
                                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                                        <!--Modal title-->
                                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white"
                                            id="exampleModalLabel">
                                            Modal title
                                        </h5>
                                        <!-- Close button -->
                                        <button type="button"
                                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                                            data-twe-modal-dismiss aria-label="Close">
                                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="relative flex justify-center p-4" data-twe-modal-body-ref>
                                        ...
                                    </div>

                                    <!-- Modal footer -->
                                    <div
                                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10">
                                        <button type="button"
                                            class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                                            data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="light">
                                            Close
                                        </button>
                                        <button type="button"
                                            class="ms-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                                            data-twe-ripple-init data-twe-ripple-color="light">
                                            Understood
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"></div>
</div>
