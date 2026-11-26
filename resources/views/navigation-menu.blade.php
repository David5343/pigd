@php
    $menuSections = [
        [
            'label' => 'Coordinación',
            'icon' => 'coordination',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['heading' => 'Transparencia'],
                ['label' => 'Ubicación', 'route' => 'dashboard'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['heading' => 'Tecnologías'],
                ['label' => 'Permisos', 'route' => 'permissions.index'],
                ['label' => 'Roles', 'route' => 'roles.index'],
                ['label' => 'Roles vs. permisos', 'route' => 'roles.manage'],
                ['label' => 'Usuarios', 'route' => 'users.index'],
                ['label' => 'Tickets', 'route' => 'dashboard'],
                ['label' => 'Diagnósticos', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Administración',
            'icon' => 'administration',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['heading' => 'Finanzas'],
                ['label' => 'Fondo Revolvente', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Jurídico',
            'icon' => 'legal',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['label' => 'Circulares', 'route' => 'dashboard'],
                ['heading' => 'Gestión'],
                ['label' => 'Dictámenes', 'route' => 'dashboard'],
                ['label' => 'Reportes', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Médica',
            'icon' => 'medical',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['label' => 'Circulares', 'route' => 'dashboard'],
                ['heading' => 'Catálogos'],
                ['label' => 'Unidades de medida', 'route' => 'medication_unit.index'],
                ['label' => 'Años de catálogo', 'route' => 'catalog_year.index'],
                ['label' => 'Medicamentos', 'route' => 'medication.index'],
                ['heading' => 'Afiliación'],
                ['label' => 'Titulares', 'route' => 'membership_medical.index'],
                ['label' => 'Familiares', 'route' => 'beneficiaries_medical.index'],
                ['heading' => 'Gestión'],
                ['label' => 'Facturas', 'route' => 'dashboard'],
                ['label' => 'Reembolsos', 'route' => 'dashboard'],
                ['label' => 'Reportes', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Humanos',
            'icon' => 'human-resources',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'categories.index'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['label' => 'Circulares', 'route' => 'dashboard'],
                ['heading' => 'Catálogos'],
                ['label' => 'Áreas', 'route' => 'areas.index'],
                ['label' => 'Bancos', 'route' => 'banks.index'],
                ['label' => 'Categorías', 'route' => 'categories.index'],
                ['label' => 'Puestos', 'route' => 'positions.index'],
                ['label' => 'Estados', 'route' => 'states.index'],
                ['label' => 'Municipios', 'route' => 'counties.index'],
                ['label' => 'Tipos de movimiento', 'route' => 'procedure-type.index'],
                ['label' => 'Tipos de contrato', 'route' => 'contract-type.index'],
                ['label' => 'Grados de estudio', 'route' => 'degrees.index'],
                ['heading' => 'Personal'],
                ['label' => 'Movimiento nominal', 'route' => 'employee-procedure.index'],
                ['label' => 'Empleados', 'route' => 'employees.index'],
                ['label' => 'Credenciales', 'route' => 'dashboard'],
                ['label' => 'Permisos', 'route' => 'dashboard'],
                ['label' => 'Vacaciones', 'route' => 'dashboard'],
                ['label' => 'Reportes', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Financieros',
            'icon' => 'finance',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['label' => 'Circulares', 'route' => 'dashboard'],
                ['heading' => 'Reportes'],
                ['label' => 'Medicamentos', 'route' => 'dashboard'],
                ['label' => 'Proveedores', 'route' => 'dashboard'],
                ['label' => 'Productos', 'route' => 'dashboard'],
                ['label' => 'Servicios', 'route' => 'dashboard'],
                ['heading' => 'Administración'],
                ['label' => 'Pago de credenciales', 'route' => 'dashboard'],
                ['label' => 'Partidas', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Materiales',
            'icon' => 'materials',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['label' => 'Circulares', 'route' => 'dashboard'],
                ['heading' => 'Catálogos'],
                ['label' => 'Categorías de proveedores', 'route' => 'supplier-category.index'],
                ['label' => 'Proveedores', 'route' => 'supplier.index'],
                ['label' => 'Productos', 'route' => 'dashboard'],
                ['heading' => 'Adquisiciones'],
                ['label' => 'Licitaciones', 'route' => 'dashboard'],
                ['label' => 'Inventario', 'route' => 'dashboard'],
                ['label' => 'Resguardos', 'route' => 'dashboard'],
            ],
        ],
        [
            'label' => 'Prestaciones',
            'icon' => 'benefits',
            'route' => 'socioeconomic_benefits.index',
            'items' => [
                ['heading' => 'Documentos'],
                ['label' => 'Oficios', 'route' => 'dashboard'],
                ['label' => 'Memorándums', 'route' => 'dashboard'],
                ['label' => 'Circulares', 'route' => 'dashboard'],
                ['heading' => 'Catálogos'],
                ['label' => 'Categorías', 'route' => 'ranks.index'],
                ['label' => 'Dependencias', 'route' => 'dependencies.index'],
                ['label' => 'Subdependencias', 'route' => 'subdependencies.index'],
                ['label' => 'Tipos de pensión', 'route' => 'pension_types.index'],
                ['label' => 'Riesgos de trabajo', 'route' => 'work_risks.index'],
                ['heading' => 'Afiliación'],
                ['label' => 'Titulares', 'route' => 'membership.index'],
                ['label' => 'Familiares', 'route' => 'beneficiaries.index'],
                ['label' => 'Pensionados', 'route' => 'pensioners.index'],
                ['label' => 'Familiares de Pensionados', 'route' => 'pensioner-beneficiaries.index'],
                ['heading' => 'Consulta'],
                ['label' => 'Reportes', 'route' => 'reports.index'],
            ],
        ],
    ];
@endphp

<nav x-data="{ open: false }" class="bg-[#075e56] text-white shadow-lg shadow-slate-900/10">
    <div class="mx-auto flex max-w-[1440px] items-center gap-3 px-4 sm:px-6 lg:px-8">
        <div class="hidden min-w-0 flex-1 items-center gap-1 lg:flex">
            @foreach ($menuSections as $section)
                <x-dropdown align="left" width="60"
                    dropdownClasses="mt-2.5"
                    contentClasses="max-h-[70vh] overflow-y-auto rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/15">
                    <x-slot name="trigger">
                        @if (isset($section['route']))
                            <div class="group inline-flex min-h-16 items-center whitespace-nowrap rounded-xl text-sm font-medium text-teal-50 transition hover:bg-white/10 hover:text-white focus-within:ring-2 focus-within:ring-white/70">
                                <a href="{{ route($section['route']) }}" class="inline-flex min-h-16 items-center gap-2 rounded-l-xl py-2 ps-3 pe-1 focus:outline-none">
                                    <x-module-icon :name="$section['icon']"
                                        class="h-[1.125rem] w-[1.125rem] shrink-0 text-teal-200 transition group-hover:text-white" />
                                    {{ $section['label'] }}
                                </a>
                                <button type="button" :aria-expanded="open.toString()" aria-haspopup="true"
                                    aria-label="Abrir menú de {{ $section['label'] }}"
                                    class="inline-flex min-h-16 items-center rounded-r-xl py-2 ps-1 pe-3 focus:outline-none">
                                    <svg class="h-4 w-4 text-teal-200 transition-transform group-hover:text-white"
                                        :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @else
                            <button type="button"
                                class="group inline-flex min-h-16 items-center gap-2 whitespace-nowrap rounded-xl px-3 text-sm font-medium text-teal-50 transition hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                                <x-module-icon :name="$section['icon']"
                                    class="h-[1.125rem] w-[1.125rem] shrink-0 text-teal-200 transition group-hover:text-white" />
                                {{ $section['label'] }}
                                <svg class="h-4 w-4 text-teal-200 transition group-hover:text-white" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($section['items'] as $item)
                            @if (isset($item['heading']))
                                <div class="{{ $loop->first ? '' : 'mt-2 border-t border-slate-100 pt-2' }} px-3 pb-1 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">
                                    {{ $item['heading'] }}
                                </div>
                            @else
                                <a href="{{ route($item['route']) }}"
                                    class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-teal-50 hover:text-teal-800 focus:bg-teal-50 focus:text-teal-800 focus:outline-none">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </x-slot>
                </x-dropdown>
            @endforeach
        </div>

        <div class="ms-auto hidden shrink-0 items-center py-2 lg:flex">
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="me-2">
                    <x-dropdown align="right" width="60"
                        contentClasses="rounded-2xl border border-slate-200 bg-white py-1 shadow-xl">
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-teal-50 transition hover:bg-white/10 hover:text-white">
                                {{ Auth::user()->currentTeam->name }}
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                {{ __('Administrar equipo') }}
                            </div>
                            <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                {{ __('Configuración del equipo') }}
                            </x-dropdown-link>
                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Crear equipo') }}
                                </x-dropdown-link>
                            @endcan
                            @if (Auth::user()->allTeams()->count() > 1)
                                <div class="my-1 border-t border-slate-100"></div>
                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-switchable-team :team="$team" />
                                @endforeach
                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif

        </div>

        <div class="flex min-h-14 flex-1 items-center justify-between lg:hidden">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-sm font-semibold tracking-wide">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-sm">P</span>
                PIGD
            </a>
            <button type="button" @click="open = !open" :aria-expanded="open.toString()"
                aria-label="{{ __('Abrir menú de navegación') }}"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                <svg x-show="!open" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition class="border-t border-white/10 bg-[#064f49] lg:hidden">
        <div class="mx-auto max-h-[calc(100vh-4rem)] max-w-[1440px] space-y-1 overflow-y-auto px-4 py-3 sm:px-6">
            @foreach ($menuSections as $section)
                <div x-data="{ expanded: false }" class="overflow-hidden rounded-xl">
                    @if (isset($section['route']))
                        <div class="flex items-center justify-between text-sm font-semibold text-white transition hover:bg-white/10">
                            <a href="{{ route($section['route']) }}" class="flex flex-1 items-center gap-2.5 px-3 py-3">
                                <x-module-icon :name="$section['icon']" class="h-5 w-5 text-teal-200" />
                                {{ $section['label'] }}
                            </a>
                            <button type="button" @click="expanded = !expanded" :aria-expanded="expanded.toString()"
                                aria-label="Abrir menú de {{ $section['label'] }}"
                                class="rounded-lg p-3 text-teal-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                                <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': expanded }"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @else
                        <button type="button" @click="expanded = !expanded" :aria-expanded="expanded.toString()"
                            class="flex w-full items-center justify-between px-3 py-3 text-left text-sm font-semibold text-white transition hover:bg-white/10">
                            <span class="flex items-center gap-2.5">
                                <x-module-icon :name="$section['icon']" class="h-5 w-5 text-teal-200" />
                                {{ $section['label'] }}
                            </span>
                            <svg class="h-4 w-4 text-teal-200 transition-transform" :class="{ 'rotate-180': expanded }"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                    <div x-show="expanded" x-cloak x-transition class="space-y-1 bg-black/10 px-2 py-2">
                        @foreach ($section['items'] as $item)
                            @if (isset($item['heading']))
                                <p class="px-3 pt-2 text-[10px] font-bold uppercase tracking-[0.16em] text-teal-200/70">
                                    {{ $item['heading'] }}
                                </p>
                            @else
                                <a href="{{ route($item['route']) }}"
                                    class="block rounded-lg px-3 py-2 text-sm text-teal-50 transition hover:bg-white/10 hover:text-white">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="mt-3 border-t border-white/10 px-3 py-4">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.16em] text-teal-200/70">
                        {{ __('Equipo') }}
                    </p>
                    <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        class="block rounded-lg px-3 py-2 text-sm text-teal-50 transition hover:bg-white/10">
                        {{ __('Configuración del equipo') }}
                    </a>
                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <a href="{{ route('teams.create') }}"
                            class="block rounded-lg px-3 py-2 text-sm text-teal-50 transition hover:bg-white/10">
                            {{ __('Crear equipo') }}
                        </a>
                    @endcan
                    @if (Auth::user()->allTeams()->count() > 1)
                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    </div>
</nav>
