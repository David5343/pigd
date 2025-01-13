<div class="bg-gray-200 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="flex flex-col md:flex-row justify-center md:justify-between items-center h-auto md:h-16 space-y-4 md:space-y-0">
            <!-- Navbar -->
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 w-full md:w-auto">
                <!-- Dropdown 1 -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full md:w-auto px-4 py-2 bg-emerald-600 text-white rounded-lg text-lg font-semibold shadow-md transition duration-300 ease-in-out hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                        wire:click="toggleSubmenu('submenu1')">
                        Tenologías
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Submenu 1 -->
                    <div class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded-lg border border-gray-200 z-10"
                        x-data="{ open: @entangle('isSubmenu1Visible') }" x-show="open" x-transition>
                        <ul class="text-sm">
                            <li><a href="{{ route('users.index') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-200 ease-in-out">
                                    Usuarios
                                </a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-200 ease-in-out">Opción
                                    2</a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-200 ease-in-out">Opción
                                    3</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Dropdown 2 -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full md:w-auto px-4 py-2 bg-emerald-600 text-white rounded-lg text-lg font-semibold shadow-md transition duration-300 ease-in-out hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                        wire:click="toggleSubmenu('submenu2')">
                        Archivo
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Submenu 2 -->
                    <div class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded-lg border border-gray-200 z-10"
                        x-data="{ open: @entangle('isSubmenu2Visible') }" x-show="open" x-transition>
                        <ul class="text-sm">
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-green-100 transition duration-200 ease-in-out">Opción
                                    A</a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-green-100 transition duration-200 ease-in-out">Opción
                                    B</a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-green-100 transition duration-200 ease-in-out">Opción
                                    C</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Dropdown 3 -->
                <div class="relative">
                    <button
                        class="flex items-center justify-between w-full md:w-auto px-4 py-2 bg-emerald-600 text-white rounded-lg text-lg font-semibold shadow-md transition duration-300 ease-in-out hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                        wire:click="toggleSubmenu('submenu3')">
                        Transparencia
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Submenu 3 -->
                    <div class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded-lg border border-gray-200 z-10"
                        x-data="{ open: @entangle('isSubmenu3Visible') }" x-show="open" x-transition>
                        <ul class="text-sm">
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-red-100 transition duration-200 ease-in-out">Opción
                                    X</a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-red-100 transition duration-200 ease-in-out">Opción
                                    Y</a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-gray-800 hover:bg-red-100 transition duration-200 ease-in-out">Opción
                                    Z</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
