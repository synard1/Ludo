<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    protected $signature = 'user:reset-password {uuid} {newPassword}';

    protected $description = 'Reset password for a user by UUID';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $uuid = $this->argument('uuid');
        $newPassword = $this->argument('newPassword');

        $user = User::where('id', $uuid)->first();

        if (!$user) {
            $this->error("User with UUID {$uuid} not found.");
            return;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info("Password for user with UUID {$uuid} has been reset successfully.");
    }
}
