<?php

namespace Database\Seeders;

use App\Enums\Permissions\Account;
use App\Enums\Permissions\Category;
use App\Enums\Permissions\Order;
use App\Enums\Permissions\Product;
use App\Enums\Permissions\User;
use App\Enums\Role as RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...Account::values(),
            ...User::values(),
            ...Order::values(),
            ...Product::values(),
            ...Category::values(),
        ];

        foreach ($permissions as $perm) {
            Permission::findOrCreate($perm);
        }

        if (! Role::where('name', RoleEnum::CUSTOMER->value)->exists()) {
            (Role::create(['name' => RoleEnum::CUSTOMER->value]))
                ->givePermissionTo(Account::values());
        }

        if (! Role::where('name', RoleEnum::MODERATOR->value)->exists()) {
            (Role::create(['name' => RoleEnum::MODERATOR->value]))
                ->givePermissionTo([
                    ...Category::values(),
                    ...Product::values(),
                ]);
        }

        if (! Role::where('name', RoleEnum::ADMIN->value)->exists()) {
            (Role::create(['name' => RoleEnum::ADMIN->value]))
                ->givePermissionTo(Permission::all());
        }
    }
}
