# PRD de módulo — Coordinación Médica

| Campo | Valor |
|---|---|
| Producto | PIGD |
| Módulo | Coordinación Médica |
| Estado | Borrador inicial; alcance clínico/administrativo por validar |
| Versión | 0.1 |
| Responsable funcional | Pendiente |

## 1. Propósito

Proporcionar a Coordinación Médica acceso a la información de titulares y beneficiarios necesaria para sus tareas, y mantener los catálogos de medicamentos, unidades de medida y años que aparecen en la interfaz actual. El servicio médico que reciben los derechohabientes es subrogado; la credencialización y los listados diarios de elegibilidad se documentan principalmente en Prestaciones Socioeconómicas porque forman parte del acceso de los cuatro grupos al servicio.

## 2. Usuarios

Enlaces, personal de Coordinación Médica y jefaturas autorizadas. La lista exacta de roles y la separación entre consulta y administración deben validarse.

## 3. Alcance observado

- Consulta de titulares y beneficiarios, con vistas de detalle.
- Catálogo de medicamentos, importación de medicamentos, unidades de medida y catálogo de años.
- Existe un modelo de precios de medicamentos en el dominio, pero su flujo de gestión y alcance operativo deben confirmarse.
- La coordinación de la entrega de listados al proveedor subrogado y sus responsabilidades frente a Prestaciones deben confirmarse; no se asume que esta área opere la credencialización.

Las rutas web revisadas se concentran en consultas y catálogos. No se asume que el sistema registre consultas médicas, diagnósticos, recetas o tratamientos.

## 4. Objetivos

1. Dar acceso oportuno a los datos que el personal necesita para su función.
2. Mantener catálogos de medicamentos y unidades con datos consistentes.
3. Reducir errores en cargas e importaciones mediante validaciones y retroalimentación clara.
4. Proteger información personal y cualquier información de salud que se confirme dentro del alcance.

## 5. Requisitos iniciales por validar

| ID | Requisito | Prioridad |
|---|---|---|
| CM-01 | El usuario autorizado podrá buscar y consultar titulares y beneficiarios para los fines definidos por el área. | Must |
| CM-02 | El sistema mostrará únicamente los datos requeridos por la función del usuario. | Must |
| CM-03 | El personal responsable podrá mantener el catálogo de medicamentos y sus unidades conforme a reglas aprobadas. | Must |
| CM-04 | La importación de medicamentos validará el archivo antes de aplicar cambios y reportará filas aceptadas y rechazadas. | Should |
| CM-05 | Los precios y su vigencia se administrarán únicamente si el área confirma el proceso, responsables y reglas. | Confirmar alcance |
| CM-06 | Los catálogos mantendrán historial o identificación de modificaciones si así lo requiere la política de auditoría. | Should |

## 6. Flujos que requieren especificación

- Búsqueda y consulta de titulares/beneficiarios.
- Alta, actualización, importación y desactivación de medicamentos.
- Asignación de unidad, año/catálogo y precio, si aplica.
- Revisión y corrección de errores de importación.

Antes de ampliar este módulo, confirmar si su propósito es consulta administrativa o si comprende información clínica. Esta distinción afecta requisitos de privacidad, permisos y auditoría.

## 7. Datos y controles

Determinar qué datos de afiliación se necesitan para la consulta médica y qué información clínica, si alguna, guarda PIGD. Definir roles, usos permitidos, reportes y acceso a datos identificativos. Para importaciones, establecer formato, codificación, identificador único, reglas de duplicados y posibilidad de reintentar sin duplicar registros.

## 8. Criterios de aceptación propuestos

- Un usuario autorizado consulta solo las personas y datos permitidos por su rol.
- Una importación de prueba válida produce los registros esperados; una inválida explica cómo corregirla y no deja resultados parciales no aprobados.
- El catálogo mantiene una única interpretación aprobada de medicamento, unidad, vigencia y precio.

## 9. Métricas y preguntas abiertas

Medir consultas, errores de importación, duplicados, tiempo de actualización del catálogo y solicitudes de soporte. Metas pendientes.

1. ¿Qué tarea concreta realiza Coordinación Médica sobre titulares y beneficiarios?
2. ¿Qué responsabilidades tiene Coordinación Médica frente al proveedor médico subrogado y frente al envío diario de los cuatro listados?
3. ¿PIGD almacena información clínica o únicamente datos de afiliación y catálogos administrativos?
4. ¿Se requiere manejar existencias, surtimiento, prescripción o únicamente catálogo/precios?
5. ¿Cuál es el formato de importación oficial y quién lo mantiene?
6. ¿Qué información y procedimientos se trasladarán desde C#, si existen para este módulo?

## 10. Referencias de implementación

- Rutas: `routes/medical.php`.
- Controladores: `app/Http/Controllers/MedicalCoordination/` y `app/Http/Controllers/Catalogs/MedicationController.php`.
- Modelos: `app/Models/Catalogs/Medication*.php` y `MedicationUnit.php`.
- Vistas: `resources/views/medical_coordination/` y `resources/views/catalogs/medications/`.
