<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'make:user {role} {email} {password}';
    protected $description = 'Create a new user';

    public function handle()
    {
        $role = $this->argument('role');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::create([
            'list_no' => User::generateListNo($role),
            'first_name' => $this->ask('First name'),
            'last_name' => $this->ask('Last name'),
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'department' => $this->ask('Department'),
        ]);

        $this->info("User created successfully! Email: {$email}");
    }
}