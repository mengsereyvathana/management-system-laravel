<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

//        // Product Model
//        Permission::create(['name' => 'view products']);
//        Permission::create(['name' => 'create products']);
//        Permission::create(['name' => 'update products']);
//        Permission::create(['name' => 'delete products']);


        $arrayOfPermissionNames = ['view', 'create', 'update', 'delete'];
        $models = ['products', 'brands', 'categories', 'customers', 'orders'];
        $permissions = collect();

        foreach ($models as $model) {
            foreach ($arrayOfPermissionNames as $permissionName) {
                if (in_array($model, ['customers', 'orders']) && !in_array($permissionName, ['view', 'delete'])) {
                    continue;
                }

                $permission = ['name' => "{$permissionName} {$model}", 'guard_name' => 'web'];
                $permissions->push($permission);
            }
        }

        Permission::insert($permissions->toArray());
    }
}
