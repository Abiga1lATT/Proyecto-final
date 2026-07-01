# JIRA

Sistema web de gestión de proyectos colaborativos desarrollado con Laravel 13,
Breeze, spatie/laravel-permission y PostgreSQL.

## Autor

Abigail Anahi Tacuri Torres

## Stack tecnológico

- Laravel 13 + PHP 8.3
- PostgreSQL
- Laravel Breeze (autenticación)
- spatie/laravel-permission (roles y permisos)
- Blade + Tailwind CSS

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/Abiga1lATT/Proyecto-final.git
cd jira
```

2. Instalar dependencias:
```bash
composer install
npm install
```

3. Copiar el archivo de entorno:
```bash
copy .env.example .env
php artisan key:generate
```

4. Configurar la base de datos en `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gestor
DB_USERNAME=jira
DB_PASSWORD=123456
```

5. Ejecutar migraciones y seeders:
```bash
php artisan migrate:fresh --seed
```

6. Compilar assets:
```bash
npm run build
```

7. Levantar el servidor:
```bash
php artisan serve
```

## Usuarios de prueba

| Rol          | Email                      | Contraseña |
|--------------|----------------------------|------------|
| Admin        | admin@jira.com        | password   |
| Líder        | lider@jira.com        | password   |
| Colaborador  | colaborador@jira.com  | password   |
| Invitado     | invitado@jira.com     | password   |

## Roles y permisos

| Rol         | Proyectos         | Tareas                  | Usuarios       |
|-------------|-------------------|-------------------------|----------------|
| Admin       | Todo              | Todo                    | Gestionar      |
| Líder       | Crear, editar     | Crear, asignar          | —              |
| Colaborador | Ver               | Crear, editar las suyas | —              |
| Invitado    | Ver               | Solo comentar           | —              |

## Fases de desarrollo

| Tag   | Descripción                                      |
|-------|--------------------------------------------------|
| v0.1  | Modelos, migraciones, relaciones, factories      |
| v0.2  | Autenticación con Breeze, layout privado         |
| v0.3  | RBAC con spatie, Policies, control en Blade      |
| v0.4  | CRUD completo: proyectos, tareas, comentarios    |
| v1.0  | Filtros, paginación, dashboard, errores, README  |