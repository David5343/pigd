<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SocioeconomicBenefitsDashboardController extends Controller
{
    public function index()
    {
        $graficaGeneral = $this->crearGrafica(
            'Total de activos por tipo de derechohabiente',
            $this->activosPorTipoDeDerechohabiente(),
            'tipo de derechohabiente',
            'Para titulares y familiares incluye Preafiliado y Baja por aplicar como activos.',
        );

        $graficasPorTipo = [
            'titular' => [
                'nombre' => 'Titulares',
                'graficas' => [
                    'estatus' => $this->crearGrafica('Titulares', $this->estatusTitulares()),
                    'dependencia' => $this->crearGrafica(
                        'Titulares activos por dependencia',
                        $this->activosTitularesPorDependencia(),
                        'dependencia',
                        'Incluye Activo, Preafiliado y Baja por aplicar.',
                    ),
                    'subdependencia' => $this->crearGrafica(
                        'Titulares activos por subdependencia',
                        $this->activosTitularesPorSubdependencia(),
                        'subdependencia',
                        'Incluye Activo, Preafiliado y Baja por aplicar.',
                    ),
                    'sexo' => $this->crearGrafica(
                        'Titulares activos por sexo',
                        $this->activosTitularesPorSexo(),
                        'sexo',
                        'Incluye Activo, Preafiliado y Baja por aplicar.',
                    ),
                    'dependencia-sexo' => $this->crearGrafica(
                        'Titulares activos por dependencia y sexo',
                        $this->activosTitularesPorDependenciaYSexo(),
                        'dependencia y sexo',
                        'Incluye Activo, Preafiliado y Baja por aplicar.',
                    ),
                ],
            ],
            'familiar' => [
                'nombre' => 'Familiares',
                'graficas' => [
                    'estatus' => $this->crearGrafica('Familiares', $this->conteoPorEstatus('beneficiaries', 'affiliate_status')),
                    'parentesco' => $this->crearGrafica(
                        'Familiares activos por parentesco',
                        $this->familiaresActivosPorParentesco(),
                        'parentesco',
                        'Incluye Activo y Baja por aplicar.',
                    ),
                ],
            ],
            'pensionado' => [
                'nombre' => 'Pensionados',
                'graficas' => [
                    'estatus' => $this->crearGrafica('Pensionados', $this->conteoPorEstatus('pensioners', 'status')),
                    'sexo' => $this->crearGrafica(
                        'Pensionados activos por sexo',
                        $this->pensionadosPorSexo(),
                        'sexo',
                    ),
                    'tipo-pension' => $this->crearGrafica(
                        'Pensionados activos por tipo de pensión',
                        $this->pensionadosPorTipoDePension(),
                        'tipo de pensión',
                    ),
                ],
            ],
            'familiar-de-pensionado' => [
                'nombre' => 'Familiares de pensionados',
                'graficas' => [
                    'estatus' => $this->crearGrafica(
                        'Familiares de pensionados',
                        $this->conteoPorEstatus('pensioner_beneficiaries', 'affiliate_status'),
                    ),
                    'sexo' => $this->crearGrafica(
                        'Familiares activos de pensionados por sexo',
                        $this->familiaresPensionadosActivosPorSexo(),
                        'sexo',
                    ),
                    'parentesco' => $this->crearGrafica(
                        'Familiares activos de pensionados por parentesco',
                        $this->familiaresPensionadosActivosPorParentesco(),
                        'parentesco',
                    ),
                ],
            ],
        ];

        return view('socioeconomic_benefits.index', compact('graficaGeneral', 'graficasPorTipo'));
    }

    private function activosPorTipoDeDerechohabiente(): Collection
    {
        return collect([
            (object) [
                'label' => 'Titular',
                // Sigue la regla de las estadísticas rápidas: incluye preafiliados y bajas por aplicar.
                'total' => DB::table('insureds')->whereIn('affiliation_status_id', [1, 2, 5])->count(),
            ],
            (object) [
                'label' => 'Familiar',
                'total' => DB::table('beneficiaries')
                    ->whereIn('affiliate_status', ['Activo', 'Baja por aplicar'])
                    ->count(),
            ],
            (object) [
                'label' => 'Pensionado',
                'total' => DB::table('pensioners')->where('status', 'Activo')->count(),
            ],
            (object) [
                'label' => 'Familiar de pensionado',
                'total' => DB::table('pensioner_beneficiaries')
                    ->where('affiliate_status', 'Activo')
                    ->count(),
            ],
        ]);
    }

    private function estatusTitulares(): Collection
    {
        $conteos = DB::table('insureds')
            ->select('affiliation_status_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('affiliation_status_id')
            ->get()
            ->keyBy('affiliation_status_id');

        $estatus = DB::table('affiliation_statuses')->pluck('name', 'id');
        $estatus->put(5, 'Baja por aplicar');

        $distribucion = $estatus
            ->map(function ($nombre, $id) use ($conteos) {
                $nombre = (int) $id === 5 ? 'Baja por aplicar' : trim((string) $nombre);
                $conteo = $conteos->get($id);

                return (object) [
                    'label' => $nombre !== '' ? $nombre : 'Sin estatus',
                    'total' => (int) ($conteo->total ?? 0),
                ];
            })
            ->groupBy('label')
            ->map(fn ($grupos, $label) => (object) [
                'label' => $label,
                'total' => (int) $grupos->sum('total'),
            ])
            ->values();

        $idsEstatusConocidos = $estatus->keys()->map(fn ($id) => (int) $id)->all();
        $sinEstatus = (int) $conteos
            ->filter(fn ($conteo) => $conteo->affiliation_status_id === null
                || ! in_array((int) $conteo->affiliation_status_id, $idsEstatusConocidos, true))
            ->sum('total');

        if ($sinEstatus > 0) {
            $indiceSinEstatus = $distribucion->search(fn ($registro) => $registro->label === 'Sin estatus');

            if ($indiceSinEstatus === false) {
                $distribucion->push((object) [
                    'label' => 'Sin estatus',
                    'total' => $sinEstatus,
                ]);
            } else {
                $distribucion[$indiceSinEstatus]->total += $sinEstatus;
            }
        }

        return $distribucion->sortBy('label')->values();
    }

    private function activosTitularesPorDependencia(): Collection
    {
        $dependencia = "COALESCE(NULLIF(TRIM(dependencies.name), ''), 'Sin dependencia')";

        return DB::table('insureds')
            ->leftJoin('subdependencies', 'insureds.subdependency_id', '=', 'subdependencies.id')
            ->leftJoin('dependencies', 'subdependencies.dependency_id', '=', 'dependencies.id')
            ->whereIn('insureds.affiliation_status_id', [1, 2, 5])
            ->selectRaw("{$dependencia} as label")
            ->selectRaw('COUNT(insureds.id) as total')
            ->groupByRaw($dependencia)
            ->orderBy('label')
            ->get();
    }

    private function activosTitularesPorSubdependencia(): Collection
    {
        $subdependencia = "COALESCE(NULLIF(TRIM(subdependencies.name), ''), 'Sin subdependencia')";

        return DB::table('insureds')
            ->leftJoin('subdependencies', 'insureds.subdependency_id', '=', 'subdependencies.id')
            ->whereIn('insureds.affiliation_status_id', [1, 2, 5])
            ->selectRaw("{$subdependencia} as label")
            ->selectRaw('COUNT(insureds.id) as total')
            ->groupByRaw($subdependencia)
            ->orderBy('label')
            ->get();
    }

    private function activosTitularesPorSexo(): Collection
    {
        $sexo = "CASE
            WHEN LOWER(TRIM(COALESCE(insureds.sex, ''))) = 'hombre' THEN 'Hombre'
            WHEN LOWER(TRIM(COALESCE(insureds.sex, ''))) = 'mujer' THEN 'Mujer'
            ELSE 'Sin especificar'
        END";

        return DB::table('insureds')
            ->whereIn('insureds.affiliation_status_id', [1, 2, 5])
            ->selectRaw("{$sexo} as label")
            ->selectRaw('COUNT(insureds.id) as total')
            ->groupByRaw($sexo)
            ->orderBy('label')
            ->get();
    }

    private function activosTitularesPorDependenciaYSexo(): Collection
    {
        $dependencia = "COALESCE(NULLIF(TRIM(dependencies.name), ''), 'Sin dependencia')";
        $sexo = "CASE
            WHEN LOWER(TRIM(COALESCE(insureds.sex, ''))) = 'hombre' THEN 'Hombre'
            WHEN LOWER(TRIM(COALESCE(insureds.sex, ''))) = 'mujer' THEN 'Mujer'
            ELSE 'Sin especificar'
        END";

        return DB::table('insureds')
            ->leftJoin('subdependencies', 'insureds.subdependency_id', '=', 'subdependencies.id')
            ->leftJoin('dependencies', 'subdependencies.dependency_id', '=', 'dependencies.id')
            ->whereIn('insureds.affiliation_status_id', [1, 2, 5])
            ->selectRaw("{$dependencia} as dependencia")
            ->selectRaw("{$sexo} as sexo")
            ->selectRaw('COUNT(insureds.id) as total')
            ->groupByRaw("{$dependencia}, {$sexo}")
            ->orderBy('dependencia')
            ->orderBy('sexo')
            ->get()
            ->map(fn ($registro) => (object) [
                'label' => "{$registro->dependencia} · {$registro->sexo}",
                'total' => (int) $registro->total,
            ]);
    }

    private function familiaresActivosPorParentesco(): Collection
    {
        $parentesco = "COALESCE(NULLIF(TRIM(beneficiaries.relationship), ''), 'Sin parentesco')";

        return DB::table('beneficiaries')
            ->whereIn('beneficiaries.affiliate_status', ['Activo', 'Baja por aplicar'])
            ->selectRaw("{$parentesco} as label")
            ->selectRaw('COUNT(beneficiaries.id) as total')
            ->groupByRaw($parentesco)
            ->orderBy('label')
            ->get();
    }

    private function pensionadosPorSexo(): Collection
    {
        $sexo = "CASE
            WHEN LOWER(TRIM(COALESCE(pensioners.sex, ''))) = 'hombre' THEN 'Hombre'
            WHEN LOWER(TRIM(COALESCE(pensioners.sex, ''))) = 'mujer' THEN 'Mujer'
            ELSE 'Sin especificar'
        END";

        return DB::table('pensioners')
            ->where('pensioners.status', 'Activo')
            ->selectRaw("{$sexo} as label")
            ->selectRaw('COUNT(pensioners.id) as total')
            ->groupByRaw($sexo)
            ->orderBy('label')
            ->get();
    }

    private function pensionadosPorTipoDePension(): Collection
    {
        $tipoDePension = "COALESCE(NULLIF(TRIM(pension_types.name), ''), 'Sin tipo de pensión')";

        return DB::table('pensioners')
            ->leftJoin('pension_types', 'pensioners.pension_types_id', '=', 'pension_types.id')
            ->where('pensioners.status', 'Activo')
            ->selectRaw("{$tipoDePension} as label")
            ->selectRaw('COUNT(pensioners.id) as total')
            ->groupByRaw($tipoDePension)
            ->orderBy('label')
            ->get();
    }

    private function familiaresPensionadosActivosPorSexo(): Collection
    {
        $sexo = "CASE
            WHEN LOWER(TRIM(COALESCE(pensioner_beneficiaries.sex, ''))) = 'hombre' THEN 'Hombre'
            WHEN LOWER(TRIM(COALESCE(pensioner_beneficiaries.sex, ''))) = 'mujer' THEN 'Mujer'
            ELSE 'Sin especificar'
        END";

        return DB::table('pensioner_beneficiaries')
            ->where('pensioner_beneficiaries.affiliate_status', 'Activo')
            ->selectRaw("{$sexo} as label")
            ->selectRaw('COUNT(pensioner_beneficiaries.id) as total')
            ->groupByRaw($sexo)
            ->orderBy('label')
            ->get();
    }

    private function familiaresPensionadosActivosPorParentesco(): Collection
    {
        $parentesco = "COALESCE(NULLIF(TRIM(pensioner_beneficiaries.relationship), ''), 'Sin parentesco')";

        return DB::table('pensioner_beneficiaries')
            ->where('pensioner_beneficiaries.affiliate_status', 'Activo')
            ->selectRaw("{$parentesco} as label")
            ->selectRaw('COUNT(pensioner_beneficiaries.id) as total')
            ->groupByRaw($parentesco)
            ->orderBy('label')
            ->get();
    }

    private function conteoPorEstatus(string $tabla, string $columna): Collection
    {
        $estatus = "COALESCE(NULLIF(TRIM({$columna}), ''), 'Sin estatus')";

        return DB::table($tabla)
            ->selectRaw("{$estatus} as label")
            ->selectRaw('COUNT(*) as total')
            ->groupByRaw($estatus)
            ->orderBy('label')
            ->get();
    }

    private function crearGrafica(
        string $titulo,
        Collection $registros,
        string $criterio = 'estatus',
        ?string $nota = null,
    ): array
    {
        $coloresEstatus = [
            'activo' => '#16a34a',
            'preafiliado' => '#f59e0b',
            'baja' => '#dc2626',
            'baja por aplicar' => '#f97316',
            'bloqueado' => '#64748b',
            'sin estatus' => '#94a3b8',
            'titular' => '#075e56',
            'familiar' => '#7c3aed',
            'pensionado' => '#f59e0b',
            'familiar de pensionado' => '#db2777',
            'sin dependencia' => '#94a3b8',
            'sin subdependencia' => '#94a3b8',
            'sin parentesco' => '#94a3b8',
            'sin tipo de pensión' => '#94a3b8',
            'hombre' => '#2563eb',
            'mujer' => '#db2777',
            'sin especificar' => '#94a3b8',
        ];
        $coloresAlternos = [
            '#0f766e',
            '#7c3aed',
            '#2563eb',
            '#db2777',
            '#d97706',
            '#059669',
            '#4f46e5',
            '#e11d48',
            '#0891b2',
            '#65a30d',
        ];
        $total = (int) $registros->sum('total');
        $cantidadDeSegmentos = $registros->filter(fn ($registro) => (int) $registro->total > 0)->count();
        $anguloActual = -90;
        $segmentos = [];
        $distribucion = [];

        foreach ($registros as $indice => $registro) {
            $etiqueta = $registro->label ?: 'Sin estatus';
            $cantidad = (int) $registro->total;
            $color = $coloresEstatus[mb_strtolower($etiqueta)]
                ?? $coloresAlternos[$indice % count($coloresAlternos)];

            if ($total > 0 && $cantidad > 0) {
                $anguloTramo = ($cantidad / $total) * 360;
                $segmento = [
                    'color' => $color,
                    'completo' => $cantidadDeSegmentos === 1,
                    'path' => null,
                ];

                if (! $segmento['completo']) {
                    $centro = 80;
                    $radio = 70;
                    $anguloFinal = $anguloActual + $anguloTramo;
                    $inicioX = $centro + $radio * cos(deg2rad($anguloActual));
                    $inicioY = $centro + $radio * sin(deg2rad($anguloActual));
                    $finX = $centro + $radio * cos(deg2rad($anguloFinal));
                    $finY = $centro + $radio * sin(deg2rad($anguloFinal));
                    $arcoLargo = $anguloTramo > 180 ? 1 : 0;

                    $segmento['path'] = sprintf(
                        'M %s %s L %s %s A %s %s 0 %d 1 %s %s Z',
                        $centro,
                        $centro,
                        number_format($inicioX, 3, '.', ''),
                        number_format($inicioY, 3, '.', ''),
                        $radio,
                        $radio,
                        $arcoLargo,
                        number_format($finX, 3, '.', ''),
                        number_format($finY, 3, '.', ''),
                    );
                    $anguloActual = $anguloFinal;
                }

                $segmentos[] = $segmento;
            }

            $distribucion[] = [
                'clave' => Str::slug($etiqueta),
                'etiqueta' => $etiqueta,
                'cantidad' => $cantidad,
                'porcentaje' => $total > 0 ? round(($cantidad / $total) * 100, 1) : 0,
                'color' => $color,
            ];
        }

        return [
            'titulo' => $titulo,
            'criterio' => $criterio,
            'nota' => $nota,
            'total' => $total,
            'distribucion' => $distribucion,
            'segmentos' => $segmentos,
        ];
    }
}
