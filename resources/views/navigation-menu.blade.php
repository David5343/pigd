<nav x-data="{ open: false }" class="bg-[#009887] border-b-4 border-[#AE1922] rounded-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-17">
            <div class="flex">
                <!-- Logo -->
                {{-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div> --}}

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex"> --}}
                {{-- <div>
                    <x-dropdown-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-dropdown-link>
                </div> --}}
                <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Coordinación') }}
                                <svg class="ms-2 -me-0.5 h-6 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="relative group">
                                <div
                                    class="flex items-center justify-between px-4 py-2 text-sm text-white bg-[#009887] hover:bg-[#AE1922] hover:text-white cursor-pointer w-full">
                                    {{-- class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full"> --}}
                                    {{ __('Documentos') }}
                                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <!-- Submenú -->
                                <div
                                    class="absolute left-full top-0 mt-0 hidden group-hover:block bg-white border border-gray-200 shadow-md rounded-md w-48 z-50">
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Oficios') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Memorandums') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <div class="relative group">
                                <div
                                    class="flex items-center justify-between px-4 py-2 text-sm text-white bg-[#009887] hover:bg-[#AE1922] hover:text-white cursor-pointer w-full">
                                    {{-- class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full"> --}}
                                    {{ __('Transparencia') }}
                                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <!-- Submenú -->
                                <div
                                    class="absolute left-full top-0 mt-0 hidden group-hover:block bg-white border border-gray-200 shadow-md rounded-md w-48 z-50">
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Ubicación') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Oficios') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Memorandums') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <div class="relative group">
                                <div
                                    class="flex items-center justify-between px-4 py-2 text-sm text-white bg-[#009887] hover:bg-[#AE1922] hover:text-white cursor-pointer w-full">
                                    {{-- class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full"> --}}
                                    {{ __('Tecnologías') }}
                                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <!-- Submenú -->
                                <div
                                    class="absolute left-full top-0 mt-0 hidden group-hover:block bg-white border border-gray-200 shadow-md rounded-md w-48 z-50">
                                    <a href="{{ route('permissions.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Permisos') }}
                                    </a>
                                    <a href="{{ route('roles.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Roles') }}
                                    </a>
                                    <a href="{{ route('roles.manage') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Roles vs Permisos') }}
                                    </a>
                                    <a href="{{ route('users.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Usuarios') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Tickets') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Diagnosticos') }}
                                    </a>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Administración') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="relative group">
                                <div
                                    class="flex items-center justify-between px-4 py-2 text-sm text-white bg-[#009887] hover:bg-[#AE1922] hover:text-white cursor-pointer w-full">
                                    {{-- class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full"> --}}
                                    {{ __('Documentos') }}
                                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <!-- Submenú -->
                                <div
                                    class="absolute left-full top-0 mt-0 hidden group-hover:block bg-white border border-gray-200 shadow-md rounded-md w-48 z-50">
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Oficios') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Memorandums') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Fondo Revolvente') }}
                            </x-dropdown-link>
                            <!-- Opciones del Dropdown -->
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Jurídico') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Documentos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Oficios') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Memorandums') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Circulares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Dictamenes') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Reportes') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Médica') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Documentos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Oficios') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Memorandums') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Circulares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Título de la segunda sección -->
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Catalogos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Medicamentos') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('membership_medical.index') }}">
                                {{ __('Titulares') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('beneficiaries_medical.index') }}">
                                {{ __('Familiares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Facturas') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Reembolsos') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Reportes') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Humanos') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="relative group">
                                <div
                                    class="flex items-center justify-between px-4 py-2 text-sm text-white bg-[#009887] hover:bg-[#AE1922] hover:text-white cursor-pointer w-full">
                                    {{-- class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full"> --}}
                                    {{ __('Documentos') }}
                                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <!-- Submenú -->
                                <div
                                    class="absolute left-full top-0 mt-0 hidden group-hover:block bg-white border border-gray-200 shadow-md rounded-md w-48 z-50">
                                    <a href="{{ route('categories.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Oficios') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Memorandums') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Circulares') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <div class="relative group">
                                <div
                                    class="flex items-center justify-between px-4 py-2 text-sm text-white bg-[#009887] hover:bg-[#AE1922] hover:text-white cursor-pointer w-full">
                                    {{-- class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer w-full"> --}}
                                    {{ __('Catalogos') }}
                                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <!-- Submenú -->
                                <div
                                    class="absolute left-full top-0 mt-0 hidden group-hover:block bg-white border border-gray-200 shadow-md rounded-md w-48 z-50">
                                    <a href="{{ route('areas.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Áreas') }}
                                    </a>
                                    <a href="{{ route('banks.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Bancos') }}
                                    </a>
                                    <a href="{{ route('categories.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Categorias') }}
                                    </a>
                                    <a href="{{ route('positions.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Puestos') }}
                                    </a>
                                    <a href="{{ route('states.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Estados') }}
                                    </a>
                                    <a href="{{ route('counties.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Municipios') }}
                                    </a>
                                    <a href="{{ route('procedure-type.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Tipos de movimiento') }}
                                    </a>
                                    <a href="{{ route('contract-type.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Tipos de contrato') }}
                                    </a>
                                    <a href="{{ route('degrees.index') }}"
                                        class="block px-4 py-2 text-sm  text-gray-700  hover:bg-[#AE1922] hover:text-white">
                                        {{ __('Grados de estudio') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('employee-procedure.index') }}">
                                {{ __('Movimiento Nominal') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            {{-- <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Mas...') }}
                            </div> --}}
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('employees.index') }}">
                                {{ __('Empleados') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Credenciales') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Permisos') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Vacaciones') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Reportes') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Financieros') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Documentos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Oficios') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Memorandums') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Circulares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Título de la segunda sección -->
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Reportes') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Medicamentos') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Proveedores') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Productos') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Servicios') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Pago de Credenciales') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Partidas') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Materiales') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Documentos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Oficios') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Memorandums') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Circulares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Título de la segunda sección -->
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Catalogos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Proveedores') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Productos') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Servicios') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Licitaciones') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Inventario') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Resguardos') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="hidden space-x-2 sm:-my-px sm:ms-7 sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                {{ __('Prestaciones') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Documentos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Oficios') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Memorandums') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Circulares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Título de la segunda sección -->
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Catalogos') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('dependencies.index') }}">
                                {{ __('Dependencias') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('subdependencies.index') }}">
                                {{ __('Subdependecias') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('pension_types.index') }}">
                                {{ __('Tipos de Pensión') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('work_risks.index') }}">
                                {{ __('Tipos de riesgo de trabajo') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <!-- Título de la segunda sección -->
                            <div class="px-4 py-2 text-sm text-white bg-[#009887]">
                                {{ __('Afiliación') }}
                            </div>
                            <!-- Opciones del Dropdown -->
                            <x-dropdown-link href="{{ route('membership.index') }}">
                                {{ __('Titulares') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('beneficiaries.index') }}">
                                {{ __('Familiares') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Pensiones') }}
                            </x-dropdown-link>
                            <!-- Separador -->
                            <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Prestamos') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-1 py-6 border border-transparent text-sm leading-4 font-medium rounded-md text-black hover:text-white focus:outline-none focus:bg-tail-200 active:bg-tail-200 transition">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-[#009887] hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administrar cuenta') }}
                            </div>

                            {{-- <x-dropdown-link href="{{ route('profile.show') }}"> --}}
                            <x-dropdown-link>
                                {{ Auth::user()->name }}
                            </x-dropdown-link>
                            {{--
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif --}}

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Salir') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Coordinación General') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Administración General') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Área Jurídica') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Coordinación Médica') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Recursos Humanos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Recursos Financieros') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Recursos Materiales') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Prestaciones') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
