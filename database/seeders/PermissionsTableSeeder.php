<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        $permissions = [
            // Permisos para órdenes
            // 'ordenes.view',
            // 'ordenes.create',
            // 'ordenes.update',
            // 'ordenes.delete',
            // 'ordenes.finalizar',
            // 'ordenes.export',
            // 'ordenes.update.bodega',
            // 'ordenes.update.reparado',

            // Permisos para categorías
            'categories.manage',
            'categories.view',
            'categories.export',

            // Permisos para clientes
            'customers.manage',
            'customers.view',
            'customers.import',
            'customers.export',

            // Permisos para ventas
            'sales.manage',
            'sales.view',
            'sales.import',
            'sales.export',

            // Permisos para proveedores
            'suppliers.manage',
            'suppliers.view',
            'suppliers.import',
            'suppliers.export',

            // Permisos para productos
            'products.manage',
            'products.view',

            // Permisos para productos entrantes y salientes
            'productsIn.manage',
            'productsIn.view',
            'productsIn.export',

            'productsOut.manage',
            'productsOut.view',
            'productsOut.export',
        ];

        // Crear permisos en la base de datos
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
                'description' => 'Default description for ' . $permission,  // Aquí agregas una descripción
            ]);
        }

        // Crear el rol técnico y asignarle los permisos
        $role = Role::firstOrCreate(['name' => 'tecnico']);

        // Asignar los permisos al rol técnico
        $role->syncPermissions($permissions);

        // Asignar rol técnico a un usuario si es necesario
        // $user = User::find(1); // Reemplaza 1 con el ID del usuario
        // $user->assignRole('tecnico');
    }
}
