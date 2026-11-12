# PRD de módulo — Prestaciones Socioeconómicas

| Campo | Valor |
|---|---|
| Producto | PIGD |
| Módulo | Prestaciones Socioeconómicas |
| Estado | Borrador inicial; procesos y reglas por validar |
| Versión | 0.1 |
| Responsable funcional | Pendiente |

## 1. Propósito

Gestionar los procesos de derechohabiencia y credencialización que dan acceso a prestaciones socioeconómicas, en particular al servicio médico subrogado, y ofrecer a directivos la consulta y los reportes existentes. Este PRD distingue el uso web actual —principalmente consulta y reportes— de la operación de credencialización, hoy enfocada en la aplicación de escritorio C#.

## 2. Usuarios

Personal operativo de prestaciones y credencialización, jefaturas/coordinación y directivos que consultan información o reportes. El proveedor médico es un actor externo receptor de listados; no se asume que tendrá una cuenta de acceso a PIGD.

## 3. Contexto operativo y grupos de derechohabientes

La credencial representa el derecho de una persona a recibir el servicio médico subrogado. El alcance conocido contempla cuatro grupos:

| Grupo | Descripción conocida | Reglas pendientes |
|---|---|---|
| Trabajadores | Personas trabajadoras pertenecientes a las corporaciones atendidas por el Fideicomiso. | Elegibilidad, vigencia, altas, bajas y cambios de adscripción. |
| Familiares | Familiares vinculados a trabajadores. | Parentescos aceptados, requisitos, vigencia y excepciones. |
| Pensionados | Incluye trabajadores jubilados y viudas pensionadas. | Diferencias entre jubilación y pensión por viudez, derechos y vigencias. |
| Familiares de pensionados | Familiares que califican como derechohabientes de un pensionado. | No todos los familiares pasan a esta categoría; definir criterios, evidencias y transición. |

Cada día se extraen manualmente de la base de datos cuatro listados en Excel y se envían al proveedor del servicio médico. El contenido exacto, el formato y el control de recepción aún deben levantarse con el área y el proveedor.

## 4. Alcance observado y uso actual

- La parte web fue concebida principalmente para consulta y reportes directivos; no para realizar las operaciones cotidianas del área de Prestaciones.
- El código web contiene rutas y pantallas relacionadas con titulares y beneficiarios. Su presencia no prueba que el área las utilice o que constituyan procesos operativos aprobados.
- Catálogos de dependencias, subdependencias, tipos de pensión, categorías/rangos y riesgos de trabajo.
- Reportes de altas/bajas de titulares y beneficiarios, adscripción y resumen de indicadores.
- La aplicación de escritorio C# consume la API y está enfocada principalmente en credencializar los cuatro grupos descritos.
- La API expone operaciones para titulares, familiares, pensionados, familiares de pensionados, credenciales, turnos y catálogos; el uso real de cada operación debe confirmarse en el cliente C#.
- La preparación y envío diarios de los cuatro Excel se realizan manualmente mediante extracción desde la base de datos, según el contexto del responsable del producto.

## 5. Objetivos

1. Descubrir, documentar y validar las reglas y responsables que determinan el derecho a la prestación y la emisión de credenciales.
2. Asegurar que los cuatro grupos de derechohabientes estén diferenciados y que sus transiciones se rijan por reglas explícitas.
3. Evaluar y, si se aprueba, trasladar a la web las operaciones de credencialización necesarias que hoy dependen del cliente C#.
4. Reducir errores y trabajo manual en la preparación, validación y entrega de los cuatro listados diarios.
5. Mantener las consultas y reportes directivos vigentes sin confundirlos con las funciones operativas del área.

## 6. Requisitos iniciales por validar

| ID | Requisito | Prioridad |
|---|---|---|
| PS-01 | El personal autorizado podrá consultar la información y los reportes disponibles para su función, conforme a los permisos aprobados. | Must; alcance actual |
| PS-02 | Antes de automatizar altas, bajas, reingresos o cambios de categoría, el área aprobará reglas, responsables, evidencias y excepciones. | Must |
| PS-03 | El sistema distinguirá trabajadores, familiares, pensionados y familiares de pensionados con criterios de elegibilidad aprobados. | Must |
| PS-04 | Un cambio de situación del titular no convertirá automáticamente a todos sus familiares en familiares de pensionados; cada caso seguirá los criterios y validaciones definidos por el área. | Must |
| PS-05 | Si se aprueba la operación web, el personal autorizado podrá buscar personas y gestionar el ciclo de credencialización conforme a reglas de emisión, vigencia, renovación, reposición y baja acordadas. | Must para migración; reglas pendientes |
| PS-06 | El sistema podrá generar los cuatro listados de derechohabientes para el proveedor con contenido, formato, corte y validaciones aprobados. | Candidato; validar prioridad y viabilidad |
| PS-07 | El proceso de entrega de cada listado deberá permitir verificar periodo/corte, responsable, validación y recepción o corrección, de acuerdo con el procedimiento aprobado. | Must para el proceso; automatización por definir |
| PS-08 | Los reportes ejecutivos existentes deberán identificar periodo, filtros, definiciones y permisos de acceso. | Should |
| PS-09 | Las fotos, firmas, datos de identificación y bancarios solo estarán disponibles para roles autorizados y usos aprobados. | Must |
| PS-10 | Cada capacidad requerida de la aplicación C# deberá vincularse con un proceso validado y un flujo de destino antes de retirarla. | Must |

## 7. Flujos que requieren especificación

- Determinación de elegibilidad y alta de trabajadores.
- Registro de familiares, requisitos de parentesco, vigencias y relación con el trabajador.
- Conversión de trabajador a pensionado, diferenciando jubilación y pensión por viudez.
- Determinación de qué familiares pueden ser reconocidos como familiares de pensionados y cómo se resuelve cada caso.
- Emisión, renovación, reposición, finalización y vencimiento de credenciales, incluyendo excepciones.
- Preparación diaria de los cuatro listados, validación, envío al proveedor, confirmación de recepción y corrección de diferencias.
- Consulta y reportes ejecutivos, preservando su propósito actual.
- Gestión de turnos: creación, búsqueda, actualización y cancelación, solo si el área confirma que sigue vigente.

Los procedimientos actuales no están suficientemente establecidos ni descritos en manuales. Para cada flujo deben confirmarse actores, pasos, campos obligatorios, reglas, excepciones, autorizaciones, evidencia documental, sistemas o archivos utilizados y efectos en otros registros. La documentación del proceso es una dependencia de la automatización, no un entregable opcional posterior.

## 8. Transición desde la aplicación C#

`routes/api.php` muestra operaciones de titulares, familiares, pensionados, credenciales y catálogos. Se debe revisar el cliente C# para distinguir operaciones efectivamente usadas, el flujo de credencialización y los cuatro listados exportados. El objetivo es trasladar tareas y resultados de negocio a la web; no necesariamente conservar la forma técnica de cada endpoint.

Antes de construir, se debe verificar si el esquema actual puede representar las reglas de elegibilidad nuevas. El responsable del producto ya identifica limitaciones del diseño de datos; cualquier solución transitoria deberá tener alcance, riesgo y vida útil explícitos y no confundirse con el modelo del sistema sucesor.

## 9. Datos y controles

El módulo maneja datos personales identificativos y de contacto; el sistema también contempla información bancaria y archivos de imagen/firma. Los cuatro listados se transfieren a un proveedor externo del servicio médico. Se deben definir datos mínimos necesarios, medio seguro de entrega, destinatarios autorizados, control de versiones/cortes, acuse, conservación y eliminación. Las reglas de unicidad y calidad para folios, RFC, CURP y expedientes deben confirmarse.

## 10. Criterios de aceptación propuestos

- Los cuatro grupos de derechohabientes se validan con casos de referencia aprobados, incluidos jubilación, viudez y familiares que no califican para el grupo de pensionados.
- El área puede verificar cada una de las cuatro salidas diarias contra un conjunto de datos autorizado y explicar diferencias y exclusiones.
- Las reglas, responsables y excepciones del flujo migrado están documentados y aprobados por el área.
- Un usuario de prueba con el rol aprobado completa el flujo web aceptado sin recurrir al cliente C#.
- Los reportes ejecutivos de aceptación concuerdan con un conjunto de datos de referencia aprobado.
- El acceso a datos y archivos coincide con la matriz de autorización aprobada.

## 11. Métricas y preguntas abiertas

Medir expedientes por grupo, credenciales emitidas/renovadas, tiempo de atención, dependencia del cliente C#, tiempo de preparación de los cuatro archivos, errores/diferencias y entregas recibidas a tiempo. Establecer metas una vez levantada la línea base.

1. ¿Cuáles son los campos, reglas de filtrado y formatos de los cuatro Excel que se entregan al proveedor?
2. ¿Quién extrae, revisa, autoriza, envía y confirma cada archivo? ¿Qué ocurre ante un error o una entrega tardía?
3. ¿Qué significa operativamente “derechohabiente vigente” para cada uno de los cuatro grupos?
4. ¿Qué documentos y requisitos determinan el paso de familiar a familiar de pensionado? ¿Qué casos quedan fuera?
5. ¿Cómo se diferencian los derechos de un trabajador jubilado y una viuda pensionada?
6. ¿Qué operaciones de la API utiliza realmente la aplicación C# y cuáles son las más críticas?
7. ¿Qué procesos ya se ejecutan desde la web y cuáles solo aparecen en el código?
8. ¿Qué limitaciones específicas de la base de datos bloquean los requerimientos nuevos?
9. ¿Los turnos y todos los tipos de credenciales continúan vigentes?
10. ¿Qué reportes se consideran oficiales y cómo se calculan sus indicadores?

## 12. Referencias de implementación

- Rutas web: `routes/socioeconomic.php`.
- API: `routes/api.php`.
- Entidades principales: `app/Models/SocioeconomicBenefits/`.
- Controladores web y API: `app/Http/Controllers/SocioeconomicBenefits/` y `app/Http/Controllers/Api/SocioeconomicBenefits/`.
- Vistas: `resources/views/socioeconomic_benefits/` y `resources/views/livewire/socioeconomic-benefits/`.
