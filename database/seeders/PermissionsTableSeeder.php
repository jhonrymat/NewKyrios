<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Definir todos los permisos
        $permissions = [
            'users.index', 'users.store', 'users.update', 'users.delete',
            'roles.index', 'roles.store', 'roles.update', 'roles.delete',
            'permisos.index', 'permisos.store', 'permisos.update', 'permisos.delete',
            'log-client-error','log-viewer', 'log-viewer-dashboard', 'log-viewer-logs', 'log-viewer-phpinfo', 'log-viewer-clear', 'log-viewer-download', 'log-viewer-delete', 'log-viewer-refresh',
            'refresh-csrf',
            'ordenes.view', 'ordenes.create', 'ordenes.update', 'ordenes.edit', 'ordenes.delete', 'ordenes.finalizar', 'ordenes.export', 'ordenes.update.bodega', 'ordenes.update.reparado',
            'categories.manage', 'categories.view', 'categories.export',
            'customers.manage', 'customers.view', 'customers.import', 'customers.export',
            'sales.manage', 'sales.view', 'sales.import', 'sales.export',
            'suppliers.manage', 'suppliers.view', 'suppliers.import', 'suppliers.export',
            'products.manage', 'products.view',
            'productsIn.manage', 'productsIn.view', 'productsIn.export',
            'productsOut.manage', 'productsOut.view', 'productsOut.export',
            'perfil.edit', 'perfil.update',
        ];

        // Crear permisos en la base de datos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
                'description' => 'Default description for ' . $permission,  // Aquí agregas una descripción
            ]);
        }

        // Crear roles y asignar todos los permisos
        $adminRole = Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);
        $techRole = Role::firstOrCreate([
            'name' => 'Técnico',
            'guard_name' => 'web',
        ]);

        // Asignar los permisos al rol técnico
        $adminRole->syncPermissions($permissions);
        $techRole->syncPermissions($permissions);

        // Crear usuarios de ejemplo y asignarles roles

        // Usuario administrador
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Administrador'),  // Asegúrate de usar bcrypt o hash de tu elección
                'phone' => '3105320659',
            ]
        );
        $adminUser->assignRole($adminRole);

        // Usuario técnico
        $techUser = User::firstOrCreate(
            ['email' => 'tecnico@example.com'],
            [
                'name' => 'Técnico',
                'password' => bcrypt('Tecnico'),  // Asegúrate de usar bcrypt o hash de tu elección
                'phone' => '3118402164',
            ]
        );
        $techUser->assignRole($techRole);
    }
}
