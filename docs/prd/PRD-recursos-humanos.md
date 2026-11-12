# PRD de módulo — Recursos Humanos

| Campo | Valor |
|---|---|
| Producto | PIGD |
| Módulo | Recursos Humanos |
| Estado | Borrador inicial; procesos y reglas por validar |
| Versión | 0.1 |
| Responsable funcional | Pendiente |

## 1. Propósito

Apoyar la consulta y administración de información de empleados y movimientos/procedimientos de personal, junto con los catálogos necesarios para describir sus adscripciones, puestos y tipos de movimiento.

## 2. Usuarios

Personal de Recursos Humanos, jefaturas autorizadas y administradores de catálogos. Los roles `JefaturaHumanos` y `RecursosHumanos` aparecen en las rutas actuales; deben validarse contra los perfiles reales.

## 3. Alcance observado

- Consulta, alta, detalle y edición de empleados.
- Consulta y creación de procedimientos de empleados, con generación de PDF.
- Catálogos de áreas, bancos, categorías, puestos, estados, municipios, tipos de procedimiento, tipos de contrato y grados de estudio.

No se encontró en la evidencia revisada un inventario de operaciones equivalentes de la aplicación C# para este módulo. Su existencia y prioridad deben confirmarse.

## 4. Objetivos

1. Mantener información de empleados utilizable y consistente para los procesos del área.
2. Registrar y consultar movimientos de personal con su documentación asociada.
3. Generar documentos de movimiento correctos y verificables.
4. Asegurar que los datos personales solo sean accesibles por usuarios autorizados.

## 5. Requisitos iniciales por validar

| ID | Requisito | Prioridad |
|---|---|---|
| RH-01 | El personal autorizado podrá localizar y consultar empleados según criterios aprobados por el área. | Must |
| RH-02 | El personal autorizado podrá registrar y actualizar empleados con reglas de validación definidas por Recursos Humanos. | Must |
| RH-03 | El usuario podrá iniciar un procedimiento de empleado seleccionando el tipo de movimiento y completando los datos requeridos. | Must |
| RH-04 | El sistema conservará la relación entre empleado, procedimiento, detalles y documento generado, de acuerdo con las reglas aprobadas. | Must |
| RH-05 | El PDF mostrará la información y formato institucional vigentes, con una forma de verificar a qué procedimiento corresponde. | Should |
| RH-06 | Los catálogos estarán disponibles para los roles responsables de mantenerlos y para los formularios que los consumen. | Must |
| RH-07 | Los cambios relevantes permitirán identificar autor y fecha, conforme a la política de auditoría que se defina. | Should |

## 6. Flujos que requieren especificación

- Búsqueda y consulta de empleado.
- Alta y actualización de expediente.
- Creación, revisión, autorización y cierre de un movimiento de personal.
- Generación, descarga, impresión y conservación de documentos.
- Alta, modificación o desactivación de elementos de catálogo.

La evidencia actual muestra consulta, alta, edición y generación de PDF; no permite afirmar qué pasos de autorización o cierre existen fuera de las rutas examinadas.

## 7. Datos y controles

Confirmar los datos personales y laborales necesarios, cuáles son sensibles, qué documentos se almacenan, las políticas de retención y quién puede consultar o modificar cada dato. Definir consistencia entre el catálogo de empleados y otras áreas que consuman datos de personal, sin asumir que PIGD deba convertirse en la fuente maestra futura.

## 8. Criterios de aceptación propuestos

- El usuario autorizado localiza un expediente por los criterios aprobados y ve información acorde a su rol.
- Los campos y reglas obligatorios corresponden a las normas del área, no solo al esquema actual.
- Un movimiento aceptado produce un documento con datos correctos y queda vinculado al empleado.
- Los usuarios sin permisos no pueden acceder a los expedientes ni documentos restringidos.

## 9. Métricas y preguntas abiertas

Medir expedientes y movimientos procesados, tiempos de atención, correcciones posteriores y documentos generados. Metas pendientes de establecer.

1. ¿Qué tipos de movimientos procesa Recursos Humanos y qué estados tiene cada uno?
2. ¿Quién solicita, revisa, autoriza y finaliza cada movimiento?
3. ¿Cuáles son las plantillas y documentos oficiales vigentes?
4. ¿Qué funciones del cliente C# están relacionadas con Recursos Humanos, si las hay?
5. ¿Qué datos son maestros en PIGD y cuáles provienen de otro sistema?

## 10. Referencias de implementación

- Rutas: `routes/human.php`.
- Controladores: `app/Http/Controllers/HumanResources/`.
- Modelos: `app/Models/HumanResources/`.
- Vistas: `resources/views/human_resources/` y `resources/views/livewire/human-resources/`.
