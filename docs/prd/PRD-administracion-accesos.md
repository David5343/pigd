# PRD de módulo — Administración de usuarios y accesos

| Campo | Valor |
|---|---|
| Producto | PIGD |
| Módulo | Administración de usuarios y accesos |
| Estado | Borrador inicial; política institucional por validar |
| Versión | 0.1 |
| Responsable funcional | Pendiente |

## 1. Propósito

Permitir la administración controlada de cuentas y de los permisos necesarios para que cada persona utilice los módulos de PIGD que le corresponden.

## 2. Usuarios

Administradores de usuarios, roles y permisos; usuarios institucionales; y, cuando siga vigente, responsables de las integraciones que usan credenciales de API. Los nombres de roles y sus facultades requieren aprobación institucional.

## 3. Alcance observado

- Acceso con autenticación web y funciones de perfil y seguridad provistas por Jetstream/Fortify.
- Administración web de usuarios restringida a determinados roles.
- Administración de roles y permisos con Spatie Permission.
- Uso de Sanctum en la API, creación de tokens desde la interfaz y una ruta de inicio de sesión de API.

La existencia de estas funciones no confirma que la política de alta, baja, revisión periódica, expiración o revocación de accesos esté completa.

## 4. Objetivos

1. Dar acceso solo a cuentas autorizadas y a las funciones necesarias para su trabajo.
2. Facilitar altas, cambios y bajas de acceso con responsables y trazabilidad definidos.
3. Evitar que permisos amplios o credenciales de integración queden sin control.
4. Permitir que el retiro de la aplicación C# incluya la revocación planificada de sus credenciales/API cuando ya no sean necesarias.

## 5. Requisitos iniciales por validar

| ID | Requisito | Prioridad |
|---|---|---|
| AA-01 | Un administrador autorizado podrá crear, actualizar, desactivar y consultar cuentas conforme a la política de identidad institucional. | Must |
| AA-02 | Los roles y permisos estarán asociados a funciones aprobadas y podrán revisarse por responsables designados. | Must |
| AA-03 | Las rutas y acciones de interfaz/API comprobarán los permisos requeridos en el servidor, no únicamente la visibilidad de controles. | Must |
| AA-04 | El sistema no expondrá contraseñas, tokens en claro ni secretos al serializar o listar usuarios. | Must |
| AA-05 | La emisión, visualización, rotación, expiración y revocación de tokens tendrá reglas explícitas y un responsable. | Must |
| AA-06 | Las operaciones de administración de acceso quedarán registradas de acuerdo con la política de auditoría. | Must |
| AA-07 | La desactivación de una persona revocará o invalidará sus sesiones y credenciales según el procedimiento aprobado. | Must |
| AA-08 | La API expondrá únicamente los datos y acciones que el token/usuario autorizado necesita. | Must |

## 6. Flujos que requieren especificación

- Solicitar, aprobar, crear y desactivar una cuenta.
- Asignar roles y permisos y revisar cambios de privilegios.
- Recuperar acceso y operar autenticación multifactor, si es obligatoria.
- Crear, entregar, rotar y revocar credenciales de API.
- Retirar los accesos del cliente C# al concluir la migración a web.

## 7. Datos y controles

Definir fuente de identidad, política de contraseñas/MFA, cuentas de servicio, alcance de tokens, vigencias, proceso de revocación y registro de auditoría. Las listas de usuarios no deben incluir credenciales ni secretos. Las capacidades de la API deben revisarse por operación, no solo por autenticación general.

## 8. Criterios de aceptación propuestos

- Una persona sin autorización no puede ejecutar la acción aunque invoque directamente la ruta o acción de servidor.
- Un usuario solo puede administrar permisos si su rol incluye esa responsabilidad.
- Una respuesta de API de usuario nunca contiene contraseña, token en claro ni secreto de autenticación.
- Una cuenta desactivada deja de acceder conforme al tiempo y comportamiento acordados.
- Los tokens del cliente C# pueden revocarse de forma controlada al retirar la aplicación.

## 9. Métricas y preguntas abiertas

Medir cuentas activas, cuentas sin uso, asignaciones de privilegios revisadas, accesos revocados y eventos de acceso indebido. Metas pendientes.

1. ¿Cómo se aprueban las altas y cambios de acceso actualmente?
2. ¿Los usuarios provienen de un directorio institucional o se administran localmente?
3. ¿MFA es obligatorio para algún perfil?
4. ¿Qué tokens utiliza el cliente C# y quién es responsable de ellos?
5. ¿Qué política define vencimiento, auditoría y revisión de permisos?

## 10. Referencias de implementación

- Rutas web y roles: `routes/web.php` y rutas de cada módulo.
- API y autenticación: `routes/api.php`, `app/Http/Controllers/Api/ApiController.php`.
- Modelo de usuario: `app/Models/User.php`.
- Componentes de administración: `app/Livewire/Users/`, `app/Livewire/Roles/` y `app/Livewire/Permissions/`.
- Proveedor de permisos: `spatie/laravel-permission`.
