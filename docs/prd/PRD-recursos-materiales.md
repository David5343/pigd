# PRD de módulo — Recursos Materiales

| Campo | Valor |
|---|---|
| Producto | PIGD |
| Módulo | Recursos Materiales |
| Estado | Borrador inicial; proceso de adquisiciones por descubrir |
| Versión | 0.1 |
| Responsable funcional | Pendiente |

## 1. Propósito

Mantener la información de proveedores y sus categorías disponible para el área de Recursos Materiales. El alcance de este PRD se limita a la evidencia existente; no se presupone que PIGD ya gestione requisiciones, compras, contratos, almacén o pagos.

## 2. Usuarios

Personal de Recursos Materiales y jefaturas/administradores autorizados. Los roles aparecen en las rutas actuales y deben verificarse con el proceso real.

## 3. Alcance observado

- Consulta, alta y edición de proveedores.
- Consulta, alta y edición de categorías de proveedores.
- Acceso protegido por roles en las rutas del módulo.

## 4. Objetivos

1. Mantener un catálogo de proveedores confiable y utilizable.
2. Clasificar proveedores conforme a categorías que el área defina.
3. Evitar registros duplicados y asegurar que cambios relevantes sean atribuibles.
4. Determinar si el módulo debe permanecer como catálogo o ampliarse para cubrir otros procesos del área.

## 5. Requisitos iniciales por validar

| ID | Requisito | Prioridad |
|---|---|---|
| RM-01 | El usuario autorizado podrá buscar y consultar proveedores usando los criterios aprobados por el área. | Must |
| RM-02 | El usuario autorizado podrá registrar y actualizar proveedores con validaciones y reglas de duplicidad definidas. | Must |
| RM-03 | El personal responsable podrá administrar categorías utilizadas en la clasificación de proveedores. | Must |
| RM-04 | Los datos de contacto, fiscales y bancarios se mostrarán solo a usuarios con necesidad y permiso aprobados. | Must, si esos datos se manejan |
| RM-05 | La desactivación y conservación de proveedores seguirá las reglas administrativas y de auditoría definidas por el área. | Should |
| RM-06 | Requisiciones, cotizaciones, contratos, compras o almacén se incluirán solo tras confirmar que forman parte del alcance de PIGD. | Confirmar alcance |

## 6. Flujos que requieren especificación

- Registrar, buscar y actualizar proveedores.
- Crear y mantener categorías.
- Verificar duplicados y vigencia del proveedor.
- Consultar, exportar o compartir datos del proveedor, si es parte del proceso.

Se debe entrevistar al área para descubrir el flujo institucional desde la necesidad de compra hasta la recepción o pago. La existencia de un catálogo no demuestra que las demás etapas estén implementadas.

## 7. Datos y controles

Confirmar datos requeridos, fuentes oficiales, documentos de respaldo, tratamiento de datos fiscales/bancarios, vigencia y reglas para duplicados. Acordar roles que pueden consultar, editar, dar de baja o exportar la información.

## 8. Criterios de aceptación propuestos

- Un proveedor puede localizarse con los criterios acordados y los datos visibles respetan permisos.
- El formulario impide o advierte duplicados según reglas aprobadas.
- Los cambios de categoría no dejan proveedores en un estado ambiguo.
- Si existen procesos de compra fuera de PIGD, el PRD no se considera cubierto por el catálogo de proveedores.

## 9. Métricas y preguntas abiertas

Medir proveedores activos, duplicados detectados, tiempo de alta y actualizaciones pendientes. Metas pendientes.

1. ¿El módulo solo administra catálogos o también requisiciones, compras, contratos y almacén?
2. ¿Qué sistema es la fuente maestra de proveedores?
3. ¿Qué validaciones legales/fiscales aplican y quién aprueba cambios?
4. ¿Qué roles pueden ver información bancaria y descargar listados?
5. ¿Existe alguna funcionalidad de Recursos Materiales en la aplicación C#?

## 10. Referencias de implementación

- Rutas: `routes/material.php`.
- Controladores: `app/Http/Controllers/Catalogs/SupplierController.php` y `SupplierCategoryController.php`.
- Modelos: `app/Models/Catalogs/Supplier.php` y `SupplierCategory.php`.
- Vistas: `resources/views/catalogs/suppliers/` y `resources/views/catalogs/supplier-category/`.
