<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsersAndRoles extends Command
{
    protected $signature = 'user:list-roles';

    protected $description = 'Display all users with their associated roles';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::with('roles')->get();

        if (!$users->count()) {
            $this->info('No users found.');
            return;
        }

        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->implode(', ');

            $this->line("User ID: {$user->id}, E-mail: {$user->email}, Name: {$user->name}, Roles: {$roles}");
        }
    }
}
