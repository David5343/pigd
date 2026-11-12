# PRD principal — PIGD

| Campo | Valor |
|---|---|
| Producto | PIGD — Plataforma Institucional de Gestión de Datos |
| Estado | Borrador inicial; requiere validación con usuarios y responsables de proceso |
| Versión | 0.1 |
| Horizonte | Sistema transitorio mientras se desarrolla/adopta una plataforma sucesora |
| Última actualización | 2026-11-12 |

## 1. Resumen

PIGD (Plataforma Institucional de Gestión de Datos) fue desarrollado para el Fideicomiso del Sector Policial del Estado de Chiapas, institución que gestiona prestaciones socioeconómicas de distintas corporaciones policiales, incluido el acceso a servicio médico subrogado, pensiones y jubilaciones. Mientras se concreta su reemplazo por un sistema con un modelo de datos mejorado y capacidad para cubrir nuevos requerimientos, PIGD debe sostener los procesos prioritarios sin asumir que su diseño actual puede absorber todos los requerimientos futuros.

La aplicación de escritorio desarrollada en C# consume la API de PIGD y está enfocada principalmente en credencializar a las personas derechohabientes, como representación de su derecho al servicio médico. Se planea descontinuar esa aplicación y trasladar a la web las capacidades vigentes que se acuerden. La API y el cliente C# son fuentes para descubrir flujos; no se asume que replicar cada endpoint sea el objetivo del producto.

Este PRD define el marco común del trabajo transitorio. Los detalles por área están en los PRD de módulo.

## 2. Contexto institucional y operación actual

- La institución gestiona prestaciones socioeconómicas para personas de distintas corporaciones policiales.
- La aplicación de escritorio se centra en credencialización de cuatro grupos: trabajadores, familiares de trabajadores, pensionados y familiares de pensionados.
- Para este dominio, “pensionados” incluye tanto a trabajadores jubilados como a viudas pensionadas. “Familiares de pensionados” es una categoría propia: no todas las personas registradas previamente como familiares pasan automáticamente a ella.
- Cada día se extraen manualmente de la base de datos cuatro listados en Excel y se envían al proveedor externo del servicio médico subrogado. Deben confirmarse el contenido, corte, formato, responsables y controles de cada listado.
- La parte web fue concebida principalmente para consulta y reportes dirigidos a directivos, no para ejecutar los procesos operativos del área de Prestaciones. Que el código actual muestre rutas o formularios de alta/edición no demuestra que esos procesos estén autorizados, adoptados o completos.
- Se han descubierto requerimientos que el diseño actual de base de datos no puede soportar adecuadamente. Los procesos tampoco están establecidos y documentados de forma suficiente en manuales o procedimientos.

Por tanto, primero se deben descubrir y acordar los procesos vigentes, sus reglas y responsables; después se decide qué corregir o automatizar en PIGD durante su vida transitoria.

## 3. Problema y oportunidad

- Hay necesidades operativas que requieren correcciones y nuevas capacidades antes de que el reemplazo esté disponible.
- La credencialización depende de un cliente de escritorio legado que se retirará.
- El envío diario al proveedor médico depende de una extracción manual de cuatro listados desde la base de datos y de su distribución en Excel.
- No existe una especificación suficiente y aprobada de los procesos de elegibilidad, credencialización, cambios entre categorías y entrega de listados.
- Los requisitos nuevos ya identificados motivan una plataforma sucesora con mejor diseño de datos; no es objetivo de este esfuerzo rediseñar PIGD para convertirlo en esa plataforma.
- La web existente apoya principalmente consulta y reportes directivos; no debe confundirse ese alcance con la operación de Prestaciones.

## 4. Visión y objetivos

Mantener PIGD útil, seguro y operable durante la transición; establecer primero una comprensión validada de los procesos y luego implementar las mejoras priorizadas, incluida la sustitución web de las capacidades vigentes de credencialización que hoy dependen del cliente C#.

### Objetivos

1. Documentar y validar los procesos, responsables, criterios de elegibilidad, excepciones y datos utilizados en las operaciones prioritarias.
2. Corregir los problemas que bloquean o ponen en riesgo procesos institucionales prioritarios.
3. Sustituir en la web las capacidades operativas vigentes de la aplicación C# que las áreas aprueben, con credencialización como flujo principal identificado.
4. Reducir errores y trabajo manual en la preparación y entrega diaria de los cuatro listados al servicio médico subrogado, una vez acordadas sus reglas.
5. Mantener controles de acceso, trazabilidad y protección de datos personales en los flujos ampliados.
6. Evitar inversiones de largo plazo en cambios de arquitectura o esquema que correspondan al sistema sucesor.

### Fuera de objetivos

- Diseñar o construir el sistema sucesor dentro de este proyecto.
- Adoptar el esquema actual de PIGD como modelo de datos objetivo para la nueva plataforma.
- Migrar automáticamente cada endpoint de la API sin comprobar que corresponda a un proceso y una necesidad vigentes.
- Tratar los formularios o rutas web existentes como prueba suficiente de que el área ya opera sus prestaciones desde la web.
- Convertir la consulta y los reportes ejecutivos existentes en procesos transaccionales sin validación de los responsables del área.
- Cambiar el proceso de despliegue manual de producción sin una decisión explícita.

## 5. Usuarios y actores

Los siguientes perfiles se desprenden de los módulos y controles de acceso visibles; nombres, responsabilidades y permisos exactos deben validarse:

- Personal operativo de Prestaciones Socioeconómicas.
- Personal responsable de credencialización y preparación de los listados diarios.
- Responsable del proveedor externo del servicio médico subrogado, como receptor de información, con acceso a PIGD no asumido.
- Personal de Recursos Humanos.
- Personal de Coordinación Médica.
- Personal de Recursos Materiales.
- Administradores de usuarios, roles y permisos.
- Jefaturas que consultan información o reportes.
- Usuarios de la aplicación C# actual, que son candidatos a los flujos web sustitutos.
- Responsables técnicos y funcionales de PIGD y del proyecto sucesor.

## 6. Alcance funcional

La primera organización documental comprende un PRD principal y cinco PRD de módulo:

1. Prestaciones Socioeconómicas.
2. Recursos Humanos.
3. Coordinación Médica.
4. Recursos Materiales.
5. Administración de usuarios y accesos.

Los catálogos se documentan dentro del módulo que los utiliza. Los reportes ejecutivos observados actualmente se documentan en Prestaciones Socioeconómicas. Las áreas que solo muestran pantallas de entrada no se consideran módulos funcionales confirmados en este borrador. El alcance operativo futuro de Prestaciones se definirá a partir del descubrimiento de procesos; no se deduce de las pantallas existentes.

## 7. Requisitos de producto transversales

Los requisitos siguientes son propuestas iniciales para validación, no una declaración de que el sistema actual ya los cumpla.

| ID | Requisito | Prioridad inicial |
|---|---|---|
| PIGD-TR-01 | Los usuarios deberán completar desde la web los flujos aprobados para sustituir funciones del cliente C#. | Must |
| PIGD-TR-02 | Cada capacidad del cliente legado deberá tener una decisión documentada: migrar a web, conservar temporalmente, reemplazar por otro proceso o retirar. | Must |
| PIGD-TR-03 | Los cambios deberán respetar permisos por función y área, con acceso limitado a los datos necesarios para el rol. | Must |
| PIGD-TR-04 | Las operaciones sensibles deberán permitir identificar quién realizó el cambio y cuándo, de acuerdo con las reglas de auditoría que se validen. | Must |
| PIGD-TR-05 | La interfaz deberá comunicar errores de validación y permitir corregir la captura sin perder innecesariamente el trabajo del usuario. | Should |
| PIGD-TR-06 | Los despliegues a producción continuarán siendo manuales mientras no se apruebe y documente otro proceso. | Must |
| PIGD-TR-07 | Los requisitos y criterios de aceptación deberán describir resultados de negocio, evitando acoplarse al esquema actual cuando no sea indispensable. | Must |
| PIGD-TR-08 | Antes de automatizar un proceso operativo, el área deberá validar su responsable, pasos, reglas, excepciones, autorizaciones, datos y resultado esperado. | Must |
| PIGD-TR-09 | Antes de modificar la preparación y entrega de archivos al proveedor médico, el área deberá documentar y aprobar contenido, corte, formato, responsable, validación y manejo de correcciones. | Must |
| PIGD-TR-10 | Automatizar la generación o entrega de los listados podrá priorizarse después de validar el proceso, sus controles y su beneficio frente a otras necesidades transitorias. | Should; validar prioridad |

## 8. Transición de API y cliente C# a web

### Enfoque

El cliente C# está enfocado principalmente en credencializar a los cuatro grupos de derechohabientes. La API permite identificar operaciones disponibles, pero las rutas por sí solas no prueban su uso real, sus reglas de negocio ni el conjunto completo de funciones del cliente. Antes de implementar la paridad se debe revisar el código fuente C#, observar el trabajo del personal y validar los procesos con sus responsables.

La transición no debe empezar por asumir que la base de datos actual admite el nuevo comportamiento. Para cada requisito se deberá decidir si PIGD puede soportarlo de manera segura durante el periodo transitorio, si requiere un cambio acotado aprobado o si debe esperar al sistema sucesor.

### Matriz de migración

Cada operación o flujo debe registrar, como mínimo:

| Dato | Descripción |
|---|---|
| Capacidad | Tarea que el usuario necesita completar, expresada en lenguaje de negocio |
| Usuario y frecuencia | Quién la realiza y con qué frecuencia o volumen |
| Evidencia | Pantalla/proceso C#, endpoint, reporte, instructivo o entrevista |
| Reglas | Validaciones, estados, autorizaciones, excepciones y efectos secundarios |
| Datos | Información consultada o modificada y clasificación de sensibilidad |
| Destino web | Módulo y flujo web que atenderá la capacidad |
| Decisión | Migrar, conservar temporalmente, sustituir o retirar |
| Aceptación | Escenarios verificables acordados con el área usuaria |
| Estado | Pendiente, analizado, implementado, validado o retirado |

Para credencialización, la matriz debe distinguir los cuatro grupos de derechohabientes y registrar específicamente los criterios para que un familiar pase —o no— a ser familiar de pensionado. Para el intercambio diario con el servicio subrogado debe incluirse cada archivo/listado como una capacidad y documentar su validación y manejo de diferencias.

### Criterio para retirar el cliente legado

No se debe considerar completada la sustitución solo porque exista una pantalla web o un endpoint equivalente. Cada capacidad aprobada deberá tener un proceso documentado, un flujo web validado, permisos revisados, datos verificados y aceptación del área usuaria. La entrega de los cuatro listados al proveedor también deberá verificarse en operación antes de retirar una tarea manual o al cliente legado. La fecha y el procedimiento de retiro se definirán con los responsables de la aplicación C# y de producción.

## 9. Requisitos no funcionales y restricciones

- **Datos personales:** PIGD trata datos identificativos y de contacto; algunos procesos incluyen información bancaria, fotografías o firmas. Los listados enviados al servicio médico contienen datos de derechohabientes. Deben definirse minimización, acceso, transferencia, retención, consulta y exportación con los responsables institucionales.
- **Seguridad:** autenticación, autorización por rol/función y gestión segura de credenciales y tokens deben validarse para cada flujo.
- **Trazabilidad:** especificar qué cambios requieren historial, quién puede consultarlo y por cuánto tiempo se conserva.
- **Disponibilidad y rendimiento:** objetivos cuantitativos pendientes de establecer con las áreas y el responsable de infraestructura.
- **Compatibilidad:** la plataforma actual es Laravel 11 y producción se despliega manualmente, según el contexto confirmado por el responsable del proyecto. Los PRD no prescriben por sí solos una actualización técnica.
- **Interoperabilidad:** documentar contratos de la API que sigan siendo necesarios durante el periodo de transición y las condiciones para descontinuarlos.

## 10. Métricas de éxito

Establecer línea base y metas después de obtener datos de uso y acordarlas con las áreas:

- Porcentaje de capacidades C# aprobadas que tienen flujo web aceptado.
- Número de usuarios y operaciones que aún dependen del cliente de escritorio.
- Puntualidad, exactitud y cantidad de correcciones de los cuatro listados diarios enviados al servicio médico subrogado.
- Tiempo y pasos manuales necesarios para preparar y verificar los listados.
- Porcentaje de reglas y procesos prioritarios documentados y aprobados por sus responsables.
- Tasa de finalización y errores en los flujos web prioritarios.
- Incidentes atribuibles a permisos, calidad de datos o pérdida de información.
- Tiempo de atención de los procesos seleccionados, comparado con la línea base.

No se fijan valores objetivo en este borrador por falta de mediciones y acuerdos explícitos.

## 11. Dependencias, riesgos y supuestos

### Dependencias

- Acceso al código fuente y disponibilidad de usuarios de la aplicación C#.
- Participación de responsables de cada proceso y autorización para validar reglas.
- Acceso a documentación, formatos, reportes y casos reales anonimizados cuando corresponda.
- Coordinación con el proyecto sucesor para definir horizonte y evitar duplicar trabajo.

### Riesgos

- Que existan flujos de escritorio no documentados o distintos de lo que sugieren los endpoints.
- Que la elegibilidad de los cuatro grupos, en especial la transición de familiares a familiares de pensionados, siga dependiendo de conocimiento informal.
- Que un listado manual incompleto, tardío o con una clasificación incorrecta afecte el acceso al servicio médico subrogado.
- Que la sustitución se mida por pantallas construidas y no por procesos documentados y tareas aceptadas por usuarios.
- Que los cambios temporales generen deuda o decisiones de datos que compliquen la transición.
- Que permisos y exposición de información no se revisen al mover tareas al navegador.

### Supuestos por validar

- PIGD seguirá operando hasta que el sistema sucesor esté listo y autorizado para sustituirlo.
- La API fue consumida por el cliente C#; el inventario actual de rutas no demuestra el conjunto completo de funciones utilizadas.
- El despliegue de producción seguirá siendo manual durante este esfuerzo.

## 12. Preguntas abiertas

1. ¿Cuál es el horizonte estimado para la sustitución y qué hitos externos lo determinan?
2. ¿Quién es responsable funcional y quién aprueba cada PRD de módulo?
3. ¿Dónde está el código fuente C# y qué versión de la aplicación está en uso?
4. ¿Cuáles son los cuatro archivos/listados, qué campos contienen, a qué hora se preparan y cómo se valida su recepción?
5. ¿Quién decide el alta, baja o cambio de categoría de cada tipo de derechohabiente y con qué evidencia?
6. ¿Qué condiciones distinguen a familiares de trabajadores de familiares de pensionados? ¿Qué ocurre con cada caso cuando el titular se jubila o fallece?
7. ¿Qué procesos se realizan actualmente fuera de PIGD, en Excel, papel o mediante acuerdos informales?
8. ¿Qué áreas, roles y catálogos deben considerarse vigentes?
9. ¿Qué requisitos institucionales aplican a privacidad, conservación, auditoría y transferencia al proveedor?
10. ¿Qué métricas y niveles de servicio son aceptables durante la transición?

## 13. Evidencia del sistema actual

La organización inicial se basa en `routes/socioeconomic.php`, `routes/human.php`, `routes/medical.php`, `routes/material.php`, `routes/api.php`, los controladores, modelos y vistas existentes. Esa evidencia describe implementación observada; no sustituye validación con usuarios ni define por sí sola requisitos aprobados.
