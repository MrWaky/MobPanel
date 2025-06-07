<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'p:user:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new MobPanel user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating a new MobPanel user...');
        
        $name = $this->ask('Enter the user\'s name');
        $email = $this->ask('Enter the user\'s email');
        $password = $this->secret('Enter the user\'s password');
        $confirmPassword = $this->secret('Confirm the password');
        
        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');
            return 1;
        }
        
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        
        $isAdmin = $this->confirm('Should this user be an administrator?', true);
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => $isAdmin,
        ]);
        
        $this->info('User created successfully!');
        $this->table(['Name', 'Email', 'Admin'], [[$user->name, $user->email, $user->is_admin ? 'Yes' : 'No']]);
        
        return 0;
    }
}