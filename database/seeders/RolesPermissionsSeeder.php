<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use App\Models\Permission;
use App\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abilities = [
            'read',
            'write',
            'create',
            'delete',
            'access',
        ];

        $permissions_by_role = [
            'Super Admin' => [
                'user management',
                'role management',
                'permission management',
                'content management',
                'financial management',
                'reporting',
                'payroll',
                'disputes management',
                'api controls',
                'database management',
                'repository management',
                'setting management',
                'audit log',
                'ads portal',
                'hotspot',
                'helpdesk',
                'ticket',
                'workorder',
                'user sign',
                'user sign workorder',
                'user sign ticket',
                'user sign helpdesk',

            ],
            'Administrator' => [
                'user management',
                'reporting',
                'setting management',
                'helpdesk',
                'ticket',
                'workorder',
            ],
            'developer' => [
                'api controls',
                'database management',
                'repository management',
            ],
            'analyst' => [
                'content management',
                'financial management',
                'reporting',
                'payroll',
            ],
            'Support' => [
                'helpdesk',
                'ticket',
                'workorder',
            ],
            'Trial' => [
                'setting management',
            ],
        ];

        foreach ($permissions_by_role['Super Admin'] as $permission) {
            foreach ($abilities as $ability) {
                Permission::updateOrCreate(['name' => $ability . ' ' . $permission]);
            }
        }

        foreach ($permissions_by_role['Support'] as $permission) {
            foreach ($abilities as $ability) {
                Permission::updateOrCreate(['name' => $ability . ' ' . $permission]);
            }
        }

        foreach ($permissions_by_role as $role => $permissions) {
            $full_permissions_list = [];
            foreach ($abilities as $ability) {
                foreach ($permissions as $permission) {
                    $full_permissions_list[] = $ability . ' ' . $permission;
                }
            }
            Role::updateOrCreate(['name' => $role])->syncPermissions($full_permissions_list);
        }

        // User::where('email','=','synard1@gmail.com')->assignRole('Super Admin');
        // User::where('email','=','admin@demo.com')->assignRole('administrator');

        $user = User::where('email', 'synard1@gmail.com')->first();
        $user->assignRole('Super Admin');

        $user1 = User::where('email', 'admin@demo.com')->first();
        $user1->assignRole('Administrator');

        $user2 = User::where('email', 'support@demo.com')->first();
        $user2->assignRole('Support');

        $user2 = User::where('email', 'supervisor@demo.com')->first();
        $user2->assignRole('Support');
    }

}
