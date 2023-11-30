<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class ShowPermissions extends Command
{
    protected $signature = 'show:permissions';
    protected $description = 'Show permissions based on roles';

    public function handle()
    {
        $roleNameOrUuid = $this->ask('Enter the role name or ID to show permissions:');

        $role = Role::where('name', $roleNameOrUuid)->orWhere('id', $roleNameOrUuid)->first();

        if ($role) {
            $permissions = $role->permissions;

            if ($permissions->isEmpty()) {
                $this->info("Role '{$role->name}' has no associated permissions.");
            } else {
                $this->info("Permissions associated with role '{$role->name}':");
                foreach ($permissions as $permission) {
                    $this->line($permission->name);
                }
            }
        } else {
            $this->error("Role '{$roleNameOrUuid}' not found.");
        }
    }
}
